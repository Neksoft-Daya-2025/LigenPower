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

if (!isset($data['razorpay_order_id']) || !isset($data['razorpay_payment_id']) || !isset($data['razorpay_signature']) || !isset($data['keySecret'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$orderId = $data['razorpay_order_id'];
$paymentId = $data['razorpay_payment_id'];
$signature = $data['razorpay_signature'];
$keySecret = $data['keySecret'];

// Verify signature
$generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $keySecret);

if ($generatedSignature === $signature) {
    // Update order status
    $ordersFile = __DIR__ . '/../orders.json';
    if (file_exists($ordersFile)) {
        $orders = json_decode(file_get_contents($ordersFile), true) ?? [];
        foreach ($orders as &$order) {
            if (isset($order['razorpayOrderId']) && $order['razorpayOrderId'] === $orderId) {
                $order['razorpayPaymentId'] = $paymentId;
                $order['status'] = 'completed';
                break;
            }
        }
        file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT));
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Payment verified successfully',
        'paymentId' => $paymentId
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid payment signature'
    ]);
}
?>

