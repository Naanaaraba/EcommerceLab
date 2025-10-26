<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/product_controller.php';


$product_id = $_POST['product_id'];
$title = $_POST['product_title'];
$price = $_POST['product_price'];
$desc = $_POST['product_desc'];
$keywords = $_POST['product_keywords'];
$cat_id = $_POST['category_id'];
$brand_id = $_POST['brand_id'];


$success = update_product_ctr($product_id, $cat_id, $brand_id, $title, $price, $desc, $keywords);

if ($success) {
    $response['status'] = 'success';
    $response['message'] = 'Product has been updated successfully.';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to update product.';
}

echo json_encode($response);
