<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$usersFile = __DIR__ . '/../config/dealer-users.json';
$productsFile = __DIR__ . '/../config/products.json';
$bookingsFile = __DIR__ . '/../config/prebookings.json';
$smtpConfigFile = __DIR__ . '/../config/smtp-config.json';

function dealerReply($success, $message = '', $extra = [], $status = 200) {
    http_response_code($status);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra), JSON_UNESCAPED_SLASHES);
    exit;
}

function dealerText($value, $max = 500) {
    $value = trim((string)$value);
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
}

function loadJsonList($file, $key) {
    if (!file_exists($file)) return [];
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) && isset($data[$key]) && is_array($data[$key]) ? $data[$key] : [];
}

function saveJsonList($file, $key, $items) {
    $dir = dirname($file);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return false;
    return file_put_contents($file, json_encode([$key => array_values($items), 'updated_at' => date('c')], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX) !== false;
}

function publicProducts($productsFile) {
    $items = loadJsonList($productsFile, 'products');
    $items = array_values(array_filter($items, function($item) {
        return !isset($item['active']) || $item['active'];
    }));
    usort($items, function($a, $b) { return strcmp($a['name'] ?? '', $b['name'] ?? ''); });
    return $items;
}

function loadSmtpConfig($smtpConfigFile) {
    if (!file_exists($smtpConfigFile)) return null;
    $config = json_decode(file_get_contents($smtpConfigFile), true);
    return is_array($config) && !empty($config['fromEmail']) ? $config : null;
}

function sendPortalMail($smtpConfig, $to, $subject, $html, $replyTo = '') {
    if (!$smtpConfig || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return ['sent' => false, 'message' => 'SMTP config or recipient missing'];
    }

    $autoload = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoload)) require_once $autoload;

    if (class_exists('PHPMailer\\PHPMailer\\PHPMailer') && !empty($smtpConfig['host'])) {
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $smtpConfig['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $smtpConfig['username'] ?? '';
            $mail->Password = $smtpConfig['password'] ?? '';
            $encryption = strtolower($smtpConfig['encryption'] ?? 'tls');
            if ($encryption === 'ssl') $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            elseif ($encryption !== 'none' && $encryption !== '') $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = (int)($smtpConfig['port'] ?? 587);
            $mail->setFrom($smtpConfig['fromEmail'], $smtpConfig['fromName'] ?? 'Ligen Power');
            $mail->addAddress($to);
            if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) $mail->addReplyTo($replyTo);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;
            $mail->AltBody = trim(strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $html)));
            $mail->send();
            return ['sent' => true, 'message' => 'Email sent'];
        } catch (Exception $e) {
            return ['sent' => false, 'message' => $mail->ErrorInfo ?: $e->getMessage()];
        }
    }

    $smtpResult = sendPortalMailViaSmtpSocket($smtpConfig, $to, $subject, $html, $replyTo);
    if ($smtpResult['sent']) return $smtpResult;

    $fromEmail = $smtpConfig['fromEmail'] ?? 'no-reply@localhost';
    $fromName = $smtpConfig['fromName'] ?? 'Ligen Power';
    $headers = "From: {$fromName} <{$fromEmail}>\r\n";
    if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) $headers .= "Reply-To: {$replyTo}\r\n";
    $headers .= "MIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n";
    return @mail($to, $subject, $html, $headers) ? ['sent' => true, 'message' => 'Email sent'] : ['sent' => false, 'message' => 'SMTP socket failed: ' . $smtpResult['message'] . '; mail() failed'];
}

function smtpReadLine($socket) {
    $data = '';
    while (!feof($socket)) {
        $line = fgets($socket, 515);
        if ($line === false) break;
        $data .= $line;
        if (isset($line[3]) && $line[3] === ' ') break;
    }
    return trim($data);
}

function smtpCommand($socket, $command, $expectedCodes) {
    if ($command !== null) fwrite($socket, $command . "\r\n");
    $response = smtpReadLine($socket);
    $code = (int)substr($response, 0, 3);
    if (!in_array($code, (array)$expectedCodes, true)) {
        throw new Exception(trim($command ?: 'CONNECT') . ' failed: ' . $response);
    }
    return $response;
}

function smtpAddress($email) {
    return '<' . str_replace(["\r", "\n", '<', '>'], '', $email) . '>';
}

function smtpHeaderText($value) {
    $value = trim(str_replace(["\r", "\n"], ' ', (string)$value));
    return preg_match('/[^\x20-\x7E]/', $value) ? '=?UTF-8?B?' . base64_encode($value) . '?=' : $value;
}

function smtpDotStuff($message) {
    $message = str_replace(["\r\n", "\r"], "\n", $message);
    $message = preg_replace('/^\./m', '..', $message);
    return str_replace("\n", "\r\n", $message);
}

function sendPortalMailViaSmtpSocket($smtpConfig, $to, $subject, $html, $replyTo = '') {
    if (empty($smtpConfig['host']) || empty($smtpConfig['username']) || empty($smtpConfig['password'])) {
        return ['sent' => false, 'message' => 'SMTP host, username or password missing'];
    }
    $host = $smtpConfig['host'];
    $port = (int)($smtpConfig['port'] ?? 587);
    $encryption = strtolower($smtpConfig['encryption'] ?? 'tls');
    $remote = $encryption === 'ssl' ? 'ssl://' . $host : $host;
    $fromEmail = $smtpConfig['fromEmail'] ?? $smtpConfig['username'];
    $fromName = $smtpConfig['fromName'] ?? 'Ligen Power';
    $timeout = 25;
    $errno = 0;
    $errstr = '';

    try {
        $socket = @fsockopen($remote, $port, $errno, $errstr, $timeout);
        if (!$socket) throw new Exception($errstr ?: 'Could not connect to SMTP server');
        stream_set_timeout($socket, $timeout);
        smtpCommand($socket, null, 220);
        smtpCommand($socket, 'EHLO ' . ($_SERVER['SERVER_NAME'] ?? 'ligenpower.com'), 250);
        if ($encryption === 'tls') {
            smtpCommand($socket, 'STARTTLS', 220);
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new Exception('Could not enable TLS encryption');
            }
            smtpCommand($socket, 'EHLO ' . ($_SERVER['SERVER_NAME'] ?? 'ligenpower.com'), 250);
        }
        smtpCommand($socket, 'AUTH LOGIN', 334);
        smtpCommand($socket, base64_encode($smtpConfig['username']), 334);
        smtpCommand($socket, base64_encode($smtpConfig['password']), 235);
        smtpCommand($socket, 'MAIL FROM:' . smtpAddress($fromEmail), 250);
        smtpCommand($socket, 'RCPT TO:' . smtpAddress($to), [250, 251]);
        smtpCommand($socket, 'DATA', 354);

        $boundary = 'ligen_' . bin2hex(random_bytes(8));
        $alt = trim(strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $html)));
        $headers = [
            'Date: ' . date(DATE_RFC2822),
            'From: ' . smtpHeaderText($fromName) . ' ' . smtpAddress($fromEmail),
            'To: ' . smtpAddress($to),
            'Subject: ' . smtpHeaderText($subject),
            'MIME-Version: 1.0',
            'Content-Type: multipart/alternative; boundary="' . $boundary . '"'
        ];
        if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) $headers[] = 'Reply-To: ' . smtpAddress($replyTo);
        $body = implode("\r\n", $headers) . "\r\n\r\n" .
            '--' . $boundary . "\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n" . $alt . "\r\n\r\n" .
            '--' . $boundary . "\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n" . $html . "\r\n\r\n" .
            '--' . $boundary . "--";
        fwrite($socket, smtpDotStuff($body) . "\r\n.\r\n");
        smtpCommand($socket, null, 250);
        smtpCommand($socket, 'QUIT', 221);
        fclose($socket);
        return ['sent' => true, 'message' => 'Email sent via SMTP'];
    } catch (Exception $e) {
        if (isset($socket) && is_resource($socket)) fclose($socket);
        return ['sent' => false, 'message' => $e->getMessage()];
    }
}

function salesRecipients($smtpConfig) {
    $raw = $smtpConfig['salesEmail'] ?? $smtpConfig['recipientEmail'] ?? $smtpConfig['fromEmail'] ?? '';
    $emails = preg_split('/[,;\s]+/', (string)$raw);
    return array_values(array_unique(array_filter($emails, function($email) { return filter_var($email, FILTER_VALIDATE_EMAIL); })));
}

function bookingEmailHtml($booking, $heading, $intro) {
    $safe = function($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); };
    return '<div style="font-family:Arial,sans-serif;color:#172c26;line-height:1.55">' .
        '<h2 style="color:#33766c;margin:0 0 12px">' . $safe($heading) . '</h2>' .
        '<p>' . $safe($intro) . '</p>' .
        '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;border:1px solid #dce9e4;width:100%;max-width:640px">' .
        '<tr><td><strong>Booking ID</strong></td><td>' . $safe($booking['id'] ?? '-') . '</td></tr>' .
        '<tr><td><strong>Product</strong></td><td>' . $safe($booking['product_name'] ?? '-') . '</td></tr>' .
        '<tr><td><strong>SKU</strong></td><td>' . $safe($booking['sku'] ?? '-') . '</td></tr>' .
        '<tr><td><strong>Quantity</strong></td><td>' . $safe($booking['quantity'] ?? '-') . '</td></tr>' .
        '<tr><td><strong>Status</strong></td><td>' . $safe($booking['status'] ?? 'Pending') . '</td></tr>' .
        '<tr><td><strong>Dealer</strong></td><td>' . $safe($booking['dealer_name'] ?? '-') . '</td></tr>' .
        '<tr><td><strong>Company</strong></td><td>' . $safe($booking['company'] ?? '-') . '</td></tr>' .
        '<tr><td><strong>Email</strong></td><td>' . $safe($booking['dealer_email'] ?? '-') . '</td></tr>' .
        '<tr><td><strong>Note</strong></td><td>' . nl2br($safe($booking['note'] ?? '-')) . '</td></tr>' .
        '</table><p style="color:#63746e;font-size:13px">Ligen Power Dealer Stock Portal</p></div>';
}

function updateDealerPassword($usersFile, $email, $currentPassword, $newPassword) {
    $users = loadJsonList($usersFile, 'users');
    foreach ($users as $i => $user) {
        $hash = $user['password_hash'] ?? '';
        $legacyPassword = $user['password'] ?? null;
        $passwordMatches = $hash ? password_verify($currentPassword, $hash) : ($legacyPassword !== null && $legacyPassword === $currentPassword);
        if (strtolower($user['email'] ?? '') === strtolower($email) && $passwordMatches && !empty($user['active'])) {
            unset($users[$i]['password']);
            $users[$i]['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
            $users[$i]['updated_at'] = date('c');
            return saveJsonList($usersFile, 'users', $users);
        }
    }
    return false;
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'products') dealerReply(true, '', ['products' => publicProducts($productsFile)]);
    if ($action === 'bookings') {
        $bookings = loadJsonList($bookingsFile, 'bookings');
        usort($bookings, function($a, $b) { return strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''); });
        dealerReply(true, '', ['bookings' => $bookings]);
    }
    dealerReply(false, 'Unknown action.', [], 400);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) dealerReply(false, 'Invalid request.', [], 400);

    if ($action === 'login') {
        $email = strtolower(dealerText($data['email'] ?? '', 180));
        $password = (string)($data['password'] ?? '');
        foreach (loadJsonList($usersFile, 'users') as $user) {
            $hash = $user['password_hash'] ?? '';
            $legacyPassword = $user['password'] ?? null;
            $passwordMatches = $hash ? password_verify($password, $hash) : ($legacyPassword !== null && $legacyPassword === $password);
            if (strtolower($user['email'] ?? '') === $email && $passwordMatches && !empty($user['active'])) {
                unset($user['password']);
                unset($user['password_hash']);
                dealerReply(true, 'Login successful.', ['user' => $user]);
            }
        }
        dealerReply(false, 'Invalid login details.', [], 401);
    }

    if ($action === 'prebook') {
        $productId = dealerText($data['product_id'] ?? '', 100);
        $dealerName = dealerText($data['dealer_name'] ?? '', 180);
        $dealerEmail = strtolower(dealerText($data['dealer_email'] ?? '', 180));
        $company = dealerText($data['company'] ?? '', 180);
        $quantity = max(1, (int)($data['quantity'] ?? 0));
        $note = dealerText($data['note'] ?? '', 1000);

        if ($productId === '') dealerReply(false, 'Please select a product.', [], 422);
        if ($dealerName === '') dealerReply(false, 'Dealer name is required.', [], 422);
        if (!filter_var($dealerEmail, FILTER_VALIDATE_EMAIL)) dealerReply(false, 'Valid email is required.', [], 422);

        $product = null;
        foreach (publicProducts($productsFile) as $item) {
            if (($item['id'] ?? '') === $productId) { $product = $item; break; }
        }
        if (!$product) dealerReply(false, 'Product not found.', [], 404);
        if ($quantity > (int)($product['stock'] ?? 0)) dealerReply(false, 'Requested quantity is higher than available stock.', [], 422);

        $bookings = loadJsonList($bookingsFile, 'bookings');
        $booking = [
            'id' => 'prebook-' . time() . '-' . bin2hex(random_bytes(3)),
            'product_id' => $productId,
            'product_name' => $product['name'] ?? '',
            'sku' => $product['sku'] ?? '',
            'quantity' => $quantity,
            'dealer_name' => $dealerName,
            'dealer_email' => $dealerEmail,
            'company' => $company,
            'note' => $note,
            'status' => 'Pending',
            'created_at' => date('c')
        ];
        $bookings[] = $booking;
        if (!saveJsonList($bookingsFile, 'bookings', $bookings)) dealerReply(false, 'Could not save pre-booking.', [], 500);
        $smtpConfig = loadSmtpConfig($smtpConfigFile);
        $emailResults = [];
        $emailResults['dealer'] = sendPortalMail($smtpConfig, $dealerEmail, 'Ligen Power pre-booking received - ' . ($booking['product_name'] ?? ''), bookingEmailHtml($booking, 'Pre-booking received', 'Thank you. Your pre-booking request has been received and is pending sales team review.'), $smtpConfig['fromEmail'] ?? '');
        foreach (salesRecipients($smtpConfig) as $salesEmail) {
            $emailResults['sales'][] = sendPortalMail($smtpConfig, $salesEmail, 'New dealer pre-booking - ' . ($booking['product_name'] ?? ''), bookingEmailHtml($booking, 'New pre-booking request', 'A dealer/distributor has submitted a new pre-booking request.'), $dealerEmail);
        }
        dealerReply(true, 'Pre-booking request submitted.', ['booking' => $booking, 'email' => $emailResults]);
    }

    if ($action === 'update-booking') {
        $bookingId = dealerText($data['id'] ?? '', 120);
        $status = dealerText($data['status'] ?? '', 40);
        $allowed = ['Pending', 'Approved', 'Completed', 'Rejected'];
        if ($bookingId === '') dealerReply(false, 'Booking ID is required.', [], 422);
        if (!in_array($status, $allowed, true)) dealerReply(false, 'Invalid booking status.', [], 422);
        $bookings = loadJsonList($bookingsFile, 'bookings');
        $updated = null;
        foreach ($bookings as $i => $booking) {
            if (($booking['id'] ?? '') === $bookingId) {
                $bookings[$i]['status'] = $status;
                $bookings[$i]['updated_at'] = date('c');
                $updated = $bookings[$i];
                break;
            }
        }
        if (!$updated) dealerReply(false, 'Booking not found.', [], 404);
        if (!saveJsonList($bookingsFile, 'bookings', $bookings)) dealerReply(false, 'Could not update booking.', [], 500);
        $smtpConfig = loadSmtpConfig($smtpConfigFile);
        $emailResults = [];
        $emailResults['dealer'] = sendPortalMail($smtpConfig, $updated['dealer_email'] ?? '', 'Ligen Power pre-booking ' . $status, bookingEmailHtml($updated, 'Pre-booking status updated', 'Your pre-booking status has been updated to ' . $status . '.'), $smtpConfig['fromEmail'] ?? '');
        foreach (salesRecipients($smtpConfig) as $salesEmail) {
            $emailResults['sales'][] = sendPortalMail($smtpConfig, $salesEmail, 'Pre-booking status updated - ' . $status, bookingEmailHtml($updated, 'Pre-booking status updated', 'A pre-booking status was updated from the admin dashboard.'), $updated['dealer_email'] ?? '');
        }
        dealerReply(true, 'Pre-booking status updated.', ['booking' => $updated, 'email' => $emailResults]);
    }

    if ($action === 'change-password') {
        $email = strtolower(dealerText($data['email'] ?? '', 180));
        $currentPassword = (string)($data['current_password'] ?? '');
        $newPassword = (string)($data['new_password'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) dealerReply(false, 'Valid email is required.', [], 422);
        if (strlen($newPassword) < 8) dealerReply(false, 'New password must be at least 8 characters.', [], 422);
        if (!updateDealerPassword($usersFile, $email, $currentPassword, $newPassword)) dealerReply(false, 'Current password is incorrect.', [], 401);
        dealerReply(true, 'Password changed successfully.');
    }

    dealerReply(false, 'Unknown action.', [], 400);
}

dealerReply(false, 'Method not allowed.', [], 405);
