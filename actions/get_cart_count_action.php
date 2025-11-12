<?php
header('Content-Type: application/json');
require_once('../controllers/cart_controller.php');
require_once('../settings/core.php');

$customer_id = get_user_id();

if ($customer_id > 0) {
    $count = get_cart_count_controller($customer_id);
    echo json_encode(['status' => 'success', 'count' => $count]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid customer ID']);
}
?>
