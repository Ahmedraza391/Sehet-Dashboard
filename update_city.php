<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['city_id'];
    $city = $_POST['city'];
    $province = $_POST['province_id'];

    $update_query = "UPDATE tbl_city SET city = '$city',province_id='$province' WHERE id = $id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo "City Successfully Updated";
    } else {
        echo 'Failed to Updates City';
    }
} else {
    echo 'Invalid request';
}
?>
