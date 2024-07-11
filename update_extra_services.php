<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $extra_service_id = $_POST['extra_service_id'];
    $extra_service_name = $_POST['extra_service_name'];
    $extra_service_price = $_POST['extra_service_price'];
    $sub_service_id = $_POST['sub_service_id'];

    $update_query = "UPDATE tbl_extra_services SET extra_service = '$extra_service_name',extra_service_price='$extra_service_price',sub_services_id='$sub_service_id' WHERE id = $extra_service_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo "Extra-Service Updated Successfully";
    } else {
        echo 'Failed to Update Extra-Service';
    }
} else {
    echo 'Invalid request';
}
?>
