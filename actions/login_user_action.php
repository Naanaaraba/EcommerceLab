<?php
header('Content-Type: application/json');

session_start();

$response = array();

// TODO: Check if the user is already logged in and redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'You are already logged in';
    echo json_encode($response);
    exit();
}

require_once '../controllers/user_controller.php';

$email = $_POST['email'];
$password = $_POST['password'];



$user = login_user_ctr($email, $password);
//echo json_encode([$name, $email, $password, $phone_number, $role]);
//exit();
if ($user) {
    $_SESSION['role'] = $user['user_role'];
    $_SESSION['id'] = $user['customer_id'];
    $response['status'] = 'success';
    $response['role'] = $_SESSION['role'];
    
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to login';
}

echo json_encode($response);
