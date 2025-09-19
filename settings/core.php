
<?php
session_start();


//for header redirection
ob_start();

//funtion to check for login
function check_login(){
    if (!isset($_SESSION['id'])) {
        // header("Location: ./login/login.php");
        // exit;
        return false;
    }
    return true;
}

//function to get user ID


//function to check for role (admin, customer, etc)



?>