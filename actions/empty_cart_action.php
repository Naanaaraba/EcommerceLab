<?php
session_start();
require_once '../controllers/cart_controller.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_POST['customer_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please login to empty cart'
    ]);
    exit;
}

$customer_id = $_POST['customer_id'];

try {
    $result = empty_cart_ctr($customer_id);
    
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Cart emptied successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to empty cart'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>