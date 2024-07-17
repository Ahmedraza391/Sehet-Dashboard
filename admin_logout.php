<?php
// Start session
session_start();

// Store original password in a temporary variable
$password = $_SESSION["original_password"];

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Start a new session to set the original password
session_start();
$_SESSION["original_password"] = $password;

// Redirect to login page or another appropriate page
header("Location: admin_login.php");
exit;
?>
