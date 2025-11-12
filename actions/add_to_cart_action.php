<?php
session_start();
require_once '../controllers/cart_controller.php';

header('Content-Type: application/json');


if (!isset($_POST['customer_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login to add items to cart'
    ]);
    exit;
}

$customer_id = $_POST['customer_id'];


$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($product_id <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid product'
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

    $result = add_to_cart_ctr($customer_id, $product_id, $quantity);
    
    if ($result) {
        
        $cart_count = get_cart_item_count_ctr($customer_id);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Product added to cart successfully',
            'cart_count' => $cart_count,
            'data' => $result
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to add product to cart'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>