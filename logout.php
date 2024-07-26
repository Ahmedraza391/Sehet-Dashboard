<?php
// Start session
session_start();
$path = "";
if(isset($_SESSION['admin'])){
    $path = "admin_login.php";
}
if(isset($_SESSION['employee_user'])){
    $path = "user_login.php";
}
// Destroy the session
session_destroy();

// Redirect to login page or another appropriate page
header("Location: $path");
exit;
?>
