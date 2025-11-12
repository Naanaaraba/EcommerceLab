<?php
session_start();
require_once '../controllers/cart_controller.php';

header('Content-Type: application/json');

if (!isset($_POST['customer_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login to update cart'
    ]);
    exit;
}

$customer_id = $_POST['customer_id'];

$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

if ($cart_id <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid cart item'
    ]);
    exit;
}

if ($quantity <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Quantity must be at least 1'
    ]);
    exit;
}

try {
    $result = update_cart_item_ctr($cart_id, $quantity);
    
    if ($result) {
        $cart_total = get_cart_total_amount_ctr($customer_id);
        $cart_count = get_cart_item_count_ctr($customer_id);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Cart quantity updated successfully',
            'cart_total' => $cart_total,
            'cart_count' => $cart_count
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update cart quantity'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>