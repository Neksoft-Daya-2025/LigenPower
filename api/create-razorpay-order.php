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

if (!isset($data['amount']) || !isset($data['keyId']) || !isset($data['keySecret'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$amount = floatval($data['amount']) * 100; // Convert to paise
$keyId = $data['keyId'];
$keySecret = $data['keySecret'];

// Create Razorpay order
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_USERPWD, $keyId . ':' . $keySecret);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'amount' => $amount,
    'currency' => 'INR',
    'receipt' => 'receipt_' . time(),
    'notes' => [
        'product_id' => $data['productId'] ?? '',
        'customer_name' => $data['customerName'] ?? ''
    ]
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $orderData = json_decode($response, true);
    echo json_encode([
        'success' => true,
        'orderId' => $orderData['id'],
        'amount' => $orderData['amount'],
        'currency' => $orderData['currency'],
        'keyId' => $keyId
    ]);
} else {
    http_response_code(500);
    $errorData = json_decode($response, true);
    echo json_encode([
        'success' => false,
        'message' => $errorData['error']['description'] ?? 'Failed to create Razorpay order'
    ]);
}
?>

