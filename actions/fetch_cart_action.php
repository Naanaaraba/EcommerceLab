<?php
require_once '../controllers/cart_controller.php';
require_once '../settings/core.php';
header('Content-Type: application/json');

$response = array();
$customer_id = get_user_id();
$all_products = fetch_cart_ctr($customer_id);
$cart_total = get_cart_total_amount_ctr($customer_id);

$response['data'] = $all_products;
$response['cart_total'] = $cart_total ;
echo json_encode($response);
