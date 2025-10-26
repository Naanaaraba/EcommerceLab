<?php
require_once '../classes/product_class.php';

function add_product_ctr($product_cat, $product_brand, $product_title, $product_price, $product_desc, $product_keywords)
{
    $product = new Product();
    return $product->addProduct($product_cat, $product_brand, $product_title, $product_price, $product_desc, $product_keywords);
}

function update_product_ctr($product_id, $product_cat, $product_brand, $product_title, $product_price, $product_desc, $product_keywords)
{
    $product = new Product();
    return $product->updateProduct($product_id, $product_cat, $product_brand, $product_title, $product_price, $product_desc, $product_keywords);
}

function fetch_product_ctr()
{
    $product = new Product();
    return $product->fetchProducts();
}

function delete_product_ctr($product_id)
{
    $product = new Product();
    return $product->deleteProduct($product_id);
}

function add_image_ctr($product_id, $image_url)
{
    $product = new Product();
    return $product->saveImage($product_id, $image_url);
}


function view_single_product_ctr($product_id)
{
    $product = new Product();
    return $product->view_single_product($product_id);
}


function search_products_ctr($query_term)
{
    $product = new Product();
    return $product->search_products($query_term);
}


function filter_products_by_category_ctr($cat_id)
{
    $product = new Product();
    return $product->filter_products_by_category($cat_id);
}


function filter_products_by_brand_ctr($brand_id)
{
    $product = new Product();
    return $product->filter_products_by_brand($brand_id);
}
