<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['to']) || !isset($data['subject']) || !isset($data['message'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$to = $data['to'];
$subject = $data['subject'];
$message = $data['message'];

// Get config from request or from saved config file
$config = null;
if (isset($data['config']) && !empty($data['config'])) {
    $config = $data['config'];
} else {
    // Try to load from saved config file
    $configFile = __DIR__ . '/../config/smtp-config.json';
    if (file_exists($configFile)) {
        $savedConfig = json_decode(file_get_contents($configFile), true);
        if ($savedConfig && isset($savedConfig['host'])) {
            $config = $savedConfig;
        }
    }
}

if (!$config || !isset($config['host'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'SMTP configuration not found. Please configure SMTP in the dashboard.']);
    exit;
}

// Use PHPMailer if available, otherwise use mail() function
if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = $config['encryption'] === 'ssl' ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $config['port'];
        
        // Recipients
        $mail->setFrom($config['fromEmail'], $config['fromName'] ?? 'Ligen Power®');
        $mail->addAddress($to);
        
        // Add reply-to if email provided in message
        if (isset($data['replyTo']) && !empty($data['replyTo'])) {
            $mail->addReplyTo($data['replyTo']);
        }
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message; // Message is already HTML formatted
        $mail->AltBody = strip_tags($message);
        
        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
    }
} else {
    // Fallback to PHP mail() function
    $headers = "From: " . ($config['fromName'] ?? 'Ligen Power®') . " <" . $config['fromEmail'] . ">\r\n";
    $headers .= "Reply-To: " . $config['fromEmail'] . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    if (mail($to, $subject, nl2br($message), $headers)) {
        echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to send email']);
    }
}
?>

