<?php
session_start();
unset($_SESSION['role'], $_SESSION['id']);
session_destroy();
header('Location: ../login/login.php');

