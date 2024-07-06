<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    $check_if_exists = mysqli_query($connection, "SELECT * FROM tbl_admin WHERE admin_username = '$username'");

    if (mysqli_num_rows($check_if_exists) > 0) {
        echo "<small class='text-danger'>Username Already Exists<small>";
    } else {
        echo "<small class='text-success'>Username Available<small>";
    }
} else {
    echo "Invalid request method.";
}
?>
