<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sub_service_id = $_POST['sub_service_id'];
    $sub_service_name = $_POST['sub_service_name'];
    $sub_service_price = $_POST['sub_service_price'];
    $service_id = $_POST['service_id'];

    $update_query = "UPDATE tbl_sub_services SET sub_service = '$sub_service_name',sub_service_price='$sub_service_price',services_id='$service_id' WHERE id = $sub_service_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo "Sub-Service Updated Successfully";
    } else {
        echo 'Failed to update Sub-Service';
    }
} else {
    echo 'Invalid request';
}
?>
