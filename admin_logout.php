<?php
// Start session
session_start();
$password = $_SESSION["original_password"];
unset($_SESSION['admin']);
$_SESSION["original_password"] = $password;
// Redirect to login page or another appropriate page
header("Location: admin_login.php");
exit;
?>
