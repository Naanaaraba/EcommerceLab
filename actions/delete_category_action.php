<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/category_controller.php';

$cat_id = $_GET['cat_id'];


$success  = delete_category_ctr($cat_id);

if ($success) {
    $response['status'] = 'success';
    $response['message'] = 'Category has been deleted successfully ';
    
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to delete category';
}

echo json_encode($response);
