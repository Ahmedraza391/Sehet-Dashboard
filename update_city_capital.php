<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['city_capital_id'];
    $city_capital_name = $_POST['city_capital'];
    $city_id = $_POST['city_id'];

    $update_query = "UPDATE tbl_city_capital SET city_capital = '$city_capital_name',city_id='$city_id' WHERE id = $id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo "Successfully Updated";
    } else {
        echo 'Failed to update service';
    }
} else {
    echo 'Invalid request';
}
?>
