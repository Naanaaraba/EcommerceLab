<?php

header('Content-Type: application/json');

$response = array();

require_once '../controllers/category_controller.php';

$cat_name = $_POST['cat_name'];


$success  = add_category_ctr($cat_name);

if ($success) {
    $response['status'] = 'success';
    $response['message'] = 'Category has been added successfully ';
    
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to add category';
}

echo json_encode($response);
