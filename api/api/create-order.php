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

if (!isset($data['productId']) || !isset($data['customerName']) || !isset($data['customerEmail']) || !isset($data['customerPhone']) || !isset($data['amount'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Generate order ID
$orderId = 'ORD' . date('Ymd') . rand(1000, 9999);

$order = [
    'id' => $orderId,
    'productId' => $data['productId'],
    'productName' => $data['productName'] ?? 'Product',
    'customerName' => $data['customerName'],
    'customerEmail' => $data['customerEmail'],
    'customerPhone' => $data['customerPhone'],
    'customerAddress' => $data['customerAddress'] ?? '',
    'shippingAddress' => $data['shippingAddress'] ?? $data['customerAddress'] ?? '',
    'billingAddress' => $data['billingAddress'] ?? $data['customerAddress'] ?? '',
    'customerType' => $data['customerType'] ?? 'individual',
    'companyName' => $data['companyName'] ?? '',
    'gstin' => $data['gstin'] ?? '',
    'amount' => floatval($data['amount']),
    'status' => 'pending',
    'date' => date('Y-m-d H:i:s'),
    'razorpayOrderId' => $data['razorpayOrderId'] ?? null,
    'razorpayPaymentId' => $data['razorpayPaymentId'] ?? null
];

// Save order to file (in production, use database)
$ordersFile = __DIR__ . '/../orders.json';
$orders = [];
if (file_exists($ordersFile)) {
    $orders = json_decode(file_get_contents($ordersFile), true) ?? [];
}
$orders[] = $order;
file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'orderId' => $orderId, 'order' => $order]);
?>

