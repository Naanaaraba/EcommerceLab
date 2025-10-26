<?php
header('Content-Type: application/json');

$response = array();


require_once '../controllers/category_controller.php';
$all_categories = fetch_category_ctr();

$response = [
  'status' => 'success',
  'data' => $all_categories
];

echo json_encode($response);
