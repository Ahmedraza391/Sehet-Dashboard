<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['area_id'];
    $area = $_POST['area_name'];
    $city_capital_id = $_POST['city_capital_id'];

    $update_query = "UPDATE tbl_area SET area = '$area',city_capital_id='$city_capital_id' WHERE id = $id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo "Successfully Updated";
    } else {
        echo 'Failed to Update Area';
    }
} else {
    echo 'Invalid request';
}
?>
