<?php
header('Content-Type: application/json');
require_once '../controllers/product_controller.php';

$response = [];

$action = $_GET['action'] ?? $_POST['action'] ?? '';

try {
    switch ($action) {

        case 'view_all':
            $products = fetch_product_ctr();
            $response = [
                'status' => 'success',
                'data' => $products
            ];
            break;

        case 'view_single':
            if (!isset($_GET['product_id'])) {
                throw new Exception('Missing product ID.');
            }

            $product_id = intval($_GET['product_id']);
            $product = view_single_product_ctr($product_id);

            if ($product) {
                $response = [
                    'status' => 'success',
                    'data' => $product
                ];
            } else {
                throw new Exception('Product not found.');
            }
            break;

        case 'search':
            if (!isset($_GET['query'])) {
                throw new Exception('Search query is required.');
            }

            $query = trim($_GET['query']);
            $results = search_products_ctr($query);

            $response = [
                'status' => 'success',
                'data' => $results
            ];
            break;

        case 'filter_category':
            if (!isset($_GET['cat_id'])) {
                throw new Exception('Category ID is required.');
            }

            $cat_id = intval($_GET['cat_id']);
            $results = filter_products_by_category_ctr($cat_id);

            $response = [
                'status' => 'success',
                'data' => $results
            ];
            break;


        case 'filter_brand':
            if (!isset($_GET['brand_id'])) {
                throw new Exception('Brand ID is required.');
            }

            $brand_id = intval($_GET['brand_id']);
            $results = filter_products_by_brand_ctr($brand_id);

            $response = [
                'status' => 'success',
                'data' => $results
            ];
            break;

        default:
            throw new Exception('Invalid or missing action parameter.');
    }
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;
