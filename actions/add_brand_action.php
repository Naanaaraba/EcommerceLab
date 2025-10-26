<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/brand_controller.php';

$brand_name = $_POST['brand_name'];
$cat_id = $_POST['category_id'];

$success  = add_brand_ctr($brand_name, $cat_id);

if ($success) {
    $response['status'] = 'success';
    $response['message'] = 'Brand has been added successfully ';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to add brand';
}

echo json_encode($response);
