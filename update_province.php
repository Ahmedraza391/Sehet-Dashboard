<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $province_id = $_POST['id'];
    $province_name = $_POST['province'];

    $update_query = "UPDATE tbl_province SET province = '$province_name' WHERE id = $province_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo 'Province Updated Successfully';
    } else {
        echo 'Failed to Update Province';
    }
} else {
    echo 'Invalid request';
}
?>
