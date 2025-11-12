<?php
require_once '../classes/cart_class.php';

function add_to_cart_ctr($customer_id, $product_id, $quantity)
{
    $cart = new Cart();
    return $cart->add_to_cart($customer_id, $product_id, $quantity);
}


function update_cart_item_ctr($cart_id, $quantity)
{
    $cart = new Cart();
    return $cart->update_cart_item($cart_id, $quantity);
}

function remove_from_cart_ctr($cart_id)
{
    $cart = new Cart();
    return $cart->remove_from_cart($cart_id);
}

function fetch_cart_ctr($customer_id)
{
    $cart = new Cart();
    return $cart->fetch_cart($customer_id);
}


function empty_cart_ctr($customer_id)
{
    $cart = new Cart();
    return $cart->empty_cart($customer_id);
}


function check_product_in_cart_ctr($customer_id, $product_id)
{
    $cart = new Cart();
    return $cart->check_product_in_cart($customer_id, $product_id);
}


function get_cart_item_count_ctr($customer_id)
{
    $cart = new Cart();
    return $cart->get_cart_item_count($customer_id);
}


function get_cart_total_amount_ctr($customer_id)
{
    $cart = new Cart();
    return $cart->get_cart_total_amount($customer_id);
}

function remove_product_from_cart_ctr($customer_id, $product_id)
{
    $cart = new Cart();
    return $cart->remove_product_from_cart($customer_id, $product_id);
}

function get_cart_count_controller($customer_id) {
    $cart = new Cart();
    return $cart->get_cart_count($customer_id);
}

