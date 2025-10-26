<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/product_controller.php';

$product_id = $_POST['product_id'];

$success  = delete_product_ctr($product_id);

if ($success) {
    $response['status'] = 'success';
    $response['message'] = 'Product has been deleted successfully ';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to delete product';
}

echo json_encode($response);
