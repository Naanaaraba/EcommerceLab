<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/brand_controller.php';

$brand_id = $_GET['brand_id'];


$success  = delete_brand_ctr($brand_id);

if ($success) {
    $response['status'] = 'success';
    $response['message'] = 'Brand has been deleted successfully ';
    
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to delete brand';
}

echo json_encode($response);
