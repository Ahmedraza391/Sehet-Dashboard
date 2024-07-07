<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $city_id = $_POST['id'];
    $city_name = $_POST['city'];

    $update_query = "UPDATE tbl_city SET city = '$city_name' WHERE id = $city_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo 'City Updated Successfully';
    } else {
        echo 'Failed to Update City';
    }
} else {
    echo 'Invalid request';
}
?>
