<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/category_controller.php';

$cat_id = $_POST['cat_id'];
$cat_name = $_POST['cat_name'];


$success  = update_category_ctr($cat_id, $cat_name);

if ($success) {
    $response['status'] = 'success';
    $response['message'] = 'Category has been updated successfully ';
    
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to update category';
}

echo json_encode($response);
