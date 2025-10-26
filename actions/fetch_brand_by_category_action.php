<?php
require_once '../controllers/brand_controller.php';
header('Content-Type: application/json');

$response = array();

$cat_id = $_GET['cat_id'];
$brands_by_category = fetch_brands_by_category_ctr($cat_id);



$response = [
    'status' => 'success',
    'data' => $brands_by_category
];
echo json_encode($response);
