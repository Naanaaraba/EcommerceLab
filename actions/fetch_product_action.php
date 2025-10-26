<?php
require_once '../controllers/product_controller.php';
header('Content-Type: application/json');

$response = array();

$all_products = fetch_product_ctr();

$response['data'] = $all_products;
echo json_encode($response);
