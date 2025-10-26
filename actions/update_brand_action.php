<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/brand_controller.php';

$brand_id = $_POST['brand_id'];
$brand_name = $_POST['brand_name'];
$cat_id = $_POST['category_id'];

$success  = update_brand_ctr($brand_id, $brand_name, $cat_id);

if ($success) {
    $response['status'] = 'success';
    $response['message'] = 'Brand has been updated successfully ';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to update brand';
}

echo json_encode($response);
