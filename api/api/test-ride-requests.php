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
$storageFile = $configDir . '/test-ride-requests.json';
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

function clean_string($value, $maxLen = 200) {
	$value = is_string($value) ? trim($value) : '';
	$value = preg_replace('/\s+/', ' ', $value);
	if (strlen($value) > $maxLen) $value = substr($value, 0, $maxLen);
	return $value;
}

function send_test_ride_email($smtpConfig, $request) {
	$to = null;
	if (is_array($smtpConfig)) {
		$to = $smtpConfig['recipientEmail'] ?? ($smtpConfig['fromEmail'] ?? null);
	}

	if (!$to) {
		return ['sent' => false, 'message' => 'SMTP recipient not configured'];
	}

	$subject = 'New Test Ride Request - Electric Cycle';
	$modelLabel = $request['model'] ?? '';
	if ($modelLabel) {
		$subject .= ' (' . $modelLabel . ')';
	}

	$body = ''
		. '<h2 style="margin:0 0 12px 0;">New Test Ride Request</h2>'
		. '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;">'
		. '<tr><td><strong>Name</strong></td><td>' . htmlspecialchars($request['fullName'] ?? '', ENT_QUOTES, 'UTF-8') . '</td></tr>'
		. '<tr><td><strong>Mobile</strong></td><td>' . htmlspecialchars($request['mobile'] ?? '', ENT_QUOTES, 'UTF-8') . '</td></tr>'
		. '<tr><td><strong>Email</strong></td><td>' . htmlspecialchars($request['email'] ?? '', ENT_QUOTES, 'UTF-8') . '</td></tr>'
		. '<tr><td><strong>City</strong></td><td>' . htmlspecialchars($request['city'] ?? '', ENT_QUOTES, 'UTF-8') . '</td></tr>'
		. '<tr><td><strong>Model</strong></td><td>' . htmlspecialchars($request['model'] ?? '', ENT_QUOTES, 'UTF-8') . '</td></tr>'
		. '<tr><td><strong>Time</strong></td><td>' . htmlspecialchars($request['created_at'] ?? '', ENT_QUOTES, 'UTF-8') . '</td></tr>'
		. '</table>';

	// Try PHPMailer (if vendor/autoload exists); otherwise fall back to mail()
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

			// Reply-to customer email
			if (!empty($request['email'])) {
				$mail->addReplyTo($request['email'], $request['fullName'] ?? 'Customer');
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

	// newest first
	usort($items, function($a, $b) {
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

	$fullName = clean_string($payload['fullName'] ?? '', 120);
	$mobile = clean_string($payload['mobile'] ?? '', 30);
	$email = clean_string($payload['email'] ?? '', 120);
	$city = clean_string($payload['city'] ?? '', 80);
	$model = clean_string($payload['model'] ?? '', 80);

	if ($fullName === '' || $mobile === '' || $email === '' || $city === '' || $model === '') {
		http_response_code(400);
		echo json_encode(['success' => false, 'message' => 'Missing required fields']);
		exit;
	}

	$item = [
		'id' => bin2hex(random_bytes(8)),
		'fullName' => $fullName,
		'mobile' => $mobile,
		'email' => $email,
		'city' => $city,
		'model' => $model,
		'created_at' => date('c'),
		'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
		'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
	];

	$items = read_json_array($storageFile);
	if (!is_array($items)) $items = [];
	$items[] = $item;

	if (!write_json_array_atomic($storageFile, $items)) {
		http_response_code(500);
		echo json_encode(['success' => false, 'message' => 'Failed to save request']);
		exit;
	}

	$smtpConfig = file_exists($smtpConfigFile) ? json_decode(file_get_contents($smtpConfigFile), true) : null;
	$emailResult = send_test_ride_email($smtpConfig, $item);

	echo json_encode([
		'success' => true,
		'message' => 'Saved',
		'email' => $emailResult,
	]);
	exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
?>

