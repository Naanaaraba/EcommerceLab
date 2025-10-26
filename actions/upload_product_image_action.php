<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once '../controllers/product_controller.php';

$response = [];


$uploadDir = realpath('../uploads');


if ($uploadDir === false) {
    $uploadDir = '../uploads';
    mkdir($uploadDir, 0777, true);
}
$uploadDir = realpath($uploadDir) . '/';


if (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No image uploaded or an upload error occurred.'
    ]);
    exit;
}


$fileTmp = $_FILES['product_image']['tmp_name'];
$fileName = basename($_FILES['product_image']['name']);
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];


if (!in_array($fileExt, $allowed)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid file type. Allowed: JPG, PNG, GIF, WEBP.'
    ]);
    exit;
}

$newName = uniqid('prod_', true) . '.' . $fileExt;
$targetPath = $uploadDir . $newName;


$realUploadDir = realpath($uploadDir);
$realTargetDir = realpath(dirname($targetPath));

if ($realTargetDir === false || strpos($realTargetDir, $realUploadDir) !== 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized upload location.'
    ]);
    exit;
}


if (!move_uploaded_file($fileTmp, $targetPath)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to move uploaded file.'
    ]);
    exit;
}


$relativePath = 'uploads/' . $newName;


if (!empty($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $result = add_image_ctr($product_id, $relativePath);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Image uploaded and linked to product successfully.',
            'file_path' => $relativePath
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Image uploaded but failed to link to product in database.',
            'file_path' => $relativePath
        ]);
        exit;
    }
}


echo json_encode([
    'status' => 'success',
    'message' => 'Image uploaded successfully.',
    'file_path' => $relativePath
]);
