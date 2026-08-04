<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type');

// SMTP Configuration
$smtpConfig = [
    'host' => 'smtp.hostinger.com',
    'port' => 465,
    'username' => 'info@clasmentor.in',
    'password' => getenv('SMTP_PASSWORD'),
    'fromEmail' => 'info@clasmentor.in',
    'fromName' => 'Ligen Power®',
    'encryption' => 'ssl'
];

// Save config to file
$configDir = __DIR__ . '/../config';
if (!is_dir($configDir)) {
    mkdir($configDir, 0755, true);
}

$configFile = $configDir . '/smtp-config.json';
file_put_contents($configFile, json_encode($smtpConfig, JSON_PRETTY_PRINT));

// Test email
$testEmail = 'doprudra@gmail.com';
$subject = 'Test Email from Ligen Power® - SMTP Configuration';
$message = '
    <h2>✅ SMTP Configuration Test</h2>
    <p>This is a test email sent from the Ligen Power® website.</p>
    <hr>
    <p><strong>SMTP Host:</strong> ' . $smtpConfig['host'] . '</p>
    <p><strong>SMTP Port:</strong> ' . $smtpConfig['port'] . '</p>
    <p><strong>Encryption:</strong> ' . strtoupper($smtpConfig['encryption']) . '</p>
    <p><strong>From Email:</strong> ' . $smtpConfig['fromEmail'] . '</p>
    <p><strong>From Name:</strong> ' . $smtpConfig['fromName'] . '</p>
    <hr>
    <p><strong>Time Sent:</strong> ' . date('Y-m-d H:i:s') . '</p>
    <p><small>If you received this email, the SMTP configuration is working correctly! 🎉</small></p>
';

// Try to send email
$result = [
    'config_saved' => true,
    'config_file' => $configFile,
    'test_email' => $testEmail
];

// Use PHPMailer if available
if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $smtpConfig['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $smtpConfig['username'];
        $mail->Password = $smtpConfig['password'];
        $mail->SMTPSecure = $smtpConfig['encryption'] === 'ssl' ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtpConfig['port'];
        
        // Enable debug (optional)
        // $mail->SMTPDebug = 2;
        
        // Recipients
        $mail->setFrom($smtpConfig['fromEmail'], $smtpConfig['fromName']);
        $mail->addAddress($testEmail);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);
        
        $mail->send();
        $result['email_sent'] = true;
        $result['message'] = 'Email sent successfully using PHPMailer';
    } catch (Exception $e) {
        $result['email_sent'] = false;
        $result['error'] = 'PHPMailer Error: ' . $mail->ErrorInfo;
    }
} else {
    // Fallback to PHP mail() function
    $headers = "From: " . $smtpConfig['fromName'] . " <" . $smtpConfig['fromEmail'] . ">\r\n";
    $headers .= "Reply-To: " . $smtpConfig['fromEmail'] . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    if (mail($testEmail, $subject, nl2br($message), $headers)) {
        $result['email_sent'] = true;
        $result['message'] = 'Email sent successfully using PHP mail() function';
        $result['note'] = 'Note: PHP mail() function was used. For better reliability, install PHPMailer.';
    } else {
        $result['email_sent'] = false;
        $result['error'] = 'Failed to send email using PHP mail() function';
    }
}

echo json_encode($result, JSON_PRETTY_PRINT);
?>

