<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/product_controller.php';

$title = $_POST['product_title'];
$price = $_POST['product_price'];
$desc = $_POST['product_desc'];
$keywords = $_POST['product_keywords'];
$cat_id = $_POST['category_id'];
$brand_id = $_POST['brand_id'];

$success  = add_product_ctr($cat_id, $brand_id, $title, $price, $desc, $keywords);

if ($success) {
    $response['status'] = 'success';
    $response['product_id'] = $success;
    $response['message'] = 'Product has been added successfully ';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to add product';
}

echo json_encode($response);
