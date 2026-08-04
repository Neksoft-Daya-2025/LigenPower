<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	http_response_code(200);
	exit();
}

$configDir = __DIR__ . '/../config';
$storageFile = $configDir . '/quote-requests.json';
$smtpConfigFile = $configDir . '/smtp-config.json';

function read_json_array($filePath) {
	if (!file_exists($filePath)) return [];
	$raw = file_get_contents($filePath);
	if ($raw === false || trim($raw) === '') return [];
	$decoded = json_decode($raw, true);
	return is_array($decoded) ? $decoded : [];
}

function write_json_array_atomic($filePath, $data) {
	$dir = dirname($filePath);
	if (!is_dir($dir)) {
		mkdir($dir, 0755, true);
	}
	$tmp = $filePath . '.tmp';
	$bytes = file_put_contents($tmp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
	if ($bytes === false) return false;
	return rename($tmp, $filePath);
}

function clean_string($value, $maxLen = 500) {
	$value = is_string($value) ? trim($value) : '';
	$value = preg_replace('/\s+/', ' ', $value);
	if (strlen($value) > $maxLen) $value = substr($value, 0, $maxLen);
	return $value;
}

function clean_message($value, $maxLen = 5000) {
	$value = is_string($value) ? trim($value) : '';
	if (strlen($value) > $maxLen) $value = substr($value, 0, $maxLen);
	return $value;
}

function send_quote_email($smtpConfig, $request) {
	$to = null;
	if (is_array($smtpConfig)) {
		$to = $smtpConfig['recipientEmail'] ?? ($smtpConfig['fromEmail'] ?? null);
	}

	if (!$to) {
		return ['sent' => false, 'message' => 'SMTP recipient not configured'];
	}

	$product = $request['product_name'] ?? 'General Inquiry';
	$subject = 'Quote Request: ' . $product;

	$esc = function ($s) {
		return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
	};

	$body = ''
		. '<h2 style="margin:0 0 12px 0;">New Quote Request</h2>'
		. '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;">'
		. '<tr><td><strong>Product</strong></td><td>' . $esc($request['product_name'] ?? '') . '</td></tr>'
		. '<tr><td><strong>Page</strong></td><td>' . $esc($request['product_url'] ?? '') . '</td></tr>'
		. '<tr><td><strong>Name</strong></td><td>' . $esc($request['name'] ?? '') . '</td></tr>'
		. '<tr><td><strong>Email</strong></td><td>' . $esc($request['email'] ?? '') . '</td></tr>'
		. '<tr><td><strong>Phone</strong></td><td>' . $esc($request['phone'] ?? '') . '</td></tr>'
		. '<tr><td><strong>Company</strong></td><td>' . $esc($request['company'] ?? '') . '</td></tr>'
		. '<tr><td><strong>Quantity</strong></td><td>' . $esc($request['quantity'] ?? '') . '</td></tr>'
		. '<tr><td><strong>Message</strong></td><td>' . nl2br($esc($request['message'] ?? '')) . '</td></tr>'
		. '<tr><td><strong>Submitted</strong></td><td>' . $esc($request['created_at'] ?? '') . '</td></tr>'
		. '</table>';

	$vendorAutoload = __DIR__ . '/../vendor/autoload.php';
	if (file_exists($vendorAutoload)) {
		require_once $vendorAutoload;
	}

	if (class_exists('PHPMailer\\PHPMailer\\PHPMailer') && isset($smtpConfig['host'])) {
		$mail = new PHPMailer\PHPMailer\PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host = $smtpConfig['host'];
			$mail->SMTPAuth = true;
			$mail->Username = $smtpConfig['username'] ?? '';
			$mail->Password = $smtpConfig['password'] ?? '';

			$encryption = $smtpConfig['encryption'] ?? 'tls';
			if ($encryption === 'ssl') {
				$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
			} elseif ($encryption === 'tls') {
				$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
			} else {
				$mail->SMTPSecure = '';
				$mail->SMTPAutoTLS = false;
			}

			$mail->Port = (int)($smtpConfig['port'] ?? 587);

			$fromEmail = $smtpConfig['fromEmail'] ?? 'no-reply@localhost';
			$fromName = $smtpConfig['fromName'] ?? 'Ligen Power®';
			$mail->setFrom($fromEmail, $fromName);
			$mail->addAddress($to);

			if (!empty($request['email'])) {
				$mail->addReplyTo($request['email'], $request['name'] ?? 'Customer');
			}

			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->AltBody = strip_tags($body);

			$mail->send();
			return ['sent' => true, 'message' => 'Email sent'];
		} catch (Exception $e) {
			return ['sent' => false, 'message' => 'Mailer Error'];
		}
	}

	$fromEmail = is_array($smtpConfig) ? ($smtpConfig['fromEmail'] ?? 'no-reply@localhost') : 'no-reply@localhost';
	$fromName = is_array($smtpConfig) ? ($smtpConfig['fromName'] ?? 'Ligen Power®') : 'Ligen Power®';
	$headers = "From: " . $fromName . " <" . $fromEmail . ">\r\n";
	if (!empty($request['email'])) {
		$headers .= "Reply-To: " . $request['email'] . "\r\n";
	}
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	if (@mail($to, $subject, $body, $headers)) {
		return ['sent' => true, 'message' => 'Email sent'];
	}

	return ['sent' => false, 'message' => 'mail() failed'];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 200;
	if ($limit <= 0) $limit = 200;

	$items = read_json_array($storageFile);
	if (!is_array($items)) $items = [];

	usort($items, function ($a, $b) {
		return strcmp(($b['created_at'] ?? ''), ($a['created_at'] ?? ''));
	});

	echo json_encode([
		'success' => true,
		'count' => count($items),
		'items' => array_slice($items, 0, $limit),
	]);
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$payload = json_decode(file_get_contents('php://input'), true);
	if (!is_array($payload)) {
		http_response_code(400);
		echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
		exit;
	}

	$name = clean_string($payload['name'] ?? '', 120);
	$email = clean_string($payload['email'] ?? '', 120);
	$phone = clean_string($payload['phone'] ?? '', 30);
	$company = clean_string($payload['company'] ?? '', 120);
	$quantity = clean_string($payload['quantity'] ?? '1', 20);
	$message = clean_message($payload['message'] ?? '', 5000);
	$productName = clean_string($payload['product_name'] ?? '', 200);
	$productUrl = clean_string($payload['product_url'] ?? '', 500);
	$source = clean_string($payload['source'] ?? 'website', 80);

	if ($name === '' || $email === '' || $phone === '') {
		http_response_code(400);
		echo json_encode(['success' => false, 'message' => 'Name, email, and phone are required']);
		exit;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		http_response_code(400);
		echo json_encode(['success' => false, 'message' => 'Invalid email address']);
		exit;
	}

	$item = [
		'id' => bin2hex(random_bytes(8)),
		'name' => $name,
		'email' => $email,
		'phone' => $phone,
		'company' => $company,
		'quantity' => $quantity,
		'message' => $message,
		'product_name' => $productName,
		'product_url' => $productUrl,
		'source' => $source,
		'created_at' => date('c'),
		'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
		'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
	];

	$items = read_json_array($storageFile);
	if (!is_array($items)) $items = [];
	$items[] = $item;

	if (!write_json_array_atomic($storageFile, $items)) {
		http_response_code(500);
		echo json_encode(['success' => false, 'message' => 'Failed to save quote request']);
		exit;
	}

	$smtpConfig = file_exists($smtpConfigFile) ? json_decode(file_get_contents($smtpConfigFile), true) : null;
	$emailResult = send_quote_email($smtpConfig, $item);

	$responseMessage = 'Quote request saved successfully';
	if (!($emailResult['sent'] ?? false)) {
		$responseMessage .= '. Email notification could not be sent — check SMTP in dashboard.';
	}

	echo json_encode([
		'success' => true,
		'message' => $responseMessage,
		'id' => $item['id'],
		'email' => $emailResult,
	]);
	exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
