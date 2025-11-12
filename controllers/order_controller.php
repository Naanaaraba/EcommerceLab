<?php
require_once '../classes/order_class.php';


function create_order_ctr($customer_id, $invoice_no, $order_date) {
    $order = new Order();
    return $order->createOrder($customer_id, $invoice_no, $order_date);
}

function add_order_detail_ctr($order_id, $product_id, $qty, $price_at_purchase) {
    $order = new Order();
    return $order->addOrderDetail($order_id, $product_id, $qty, $price_at_purchase);
}


function add_payment_ctr($amt, $customer_id, $order_id, $currency = 'GHS', $payment_method = 'Card') {
    $order = new Order();
    return $order->addPayment($amt, $customer_id, $order_id, $currency, $payment_method);
}


function get_user_orders_ctr($customer_id) {
    $order = new Order();
    return $order->getUserOrders($customer_id);
}


function get_order_details_ctr($order_id) {
    $order = new Order();
    return $order->getOrderDetails($order_id);
}


function update_order_status_ctr($order_id, $status) {
    $order = new Order();
    return $order->updateOrderStatus($order_id, $status);
}


function get_order_count_ctr($customer_id) {
    $order = new Order();
    return $order->getOrderCount($customer_id);
}

function generate_invoice_number_ctr() {
    return 'ORD-' . strtoupper(uniqid());
}
?>