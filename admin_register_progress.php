<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_name = $_POST['admin_name'];
    $admin_username = $_POST['admin_username'];
    $password = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $check_if_exists = mysqli_query($connection, "SELECT * FROM tbl_admin WHERE admin_username = '$admin_username'");
    if (mysqli_num_rows($check_if_exists) > 0) {
        return "Error: Username Already Exists";
    } else {
        $image = $_FILES['admin_image'];
        $image_name = $image['name'];
        $temp_name = $image['tmp_name'];
        $path = "./assets/img/admin/";

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $target_file = $path . basename($image_name);

        if (move_uploaded_file($temp_name, $target_file)) {
            // Use prepared statements to prevent SQL injection
            $query = "INSERT INTO tbl_admin (admin_name, admin_username, admin_password, admin_image) VALUES (?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($stmt, "ssss", $admin_name, $admin_username, $password, $target_file);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Success: Account created successfully";
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "Error uploading the image.";
        }
    }
} else {
    echo "Invalid request method.";
}
?>
