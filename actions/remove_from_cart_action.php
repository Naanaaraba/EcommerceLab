<?php
session_start();
require_once '../controllers/cart_controller.php';

header('Content-Type: application/json');


if (!isset($_POST['customer_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login to remove items from cart'
    ]);
    exit;
}

$customer_id = $_POST['customer_id'];


$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

if ($cart_id <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid cart item'
    ]);
    exit;
}

try {

    $result = remove_from_cart_ctr($cart_id);
    
    if ($result) {
       
        $cart_count = get_cart_item_count_ctr($customer_id);
        $cart_total = get_cart_total_amount_ctr($customer_id);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Item removed from cart successfully',
            'cart_count' => $cart_count,
            'cart_total' => $cart_total
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to remove item from cart'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>