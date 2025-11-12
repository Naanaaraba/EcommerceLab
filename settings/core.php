
<?php
session_start();


//for header redirection
ob_start();

//funtion to check for login
function check_login(){
    if (!isset($_SESSION['id'])) {
        return false;
    }
    return true;
}

//function to get user ID
function get_user_id(){
     if (!isset($_SESSION['id'])) {
         return null;
       }
   return $_SESSION['id'];
}
//function to check for role (admin, customer, etc)
function is_admin(){
    if(isset($_SESSION['role']) && $_SESSION['role']== 1){
         return true;
    }
    return false;

}



?>