<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sub_service_id = $_POST['sub_service_id'];
    $sub_service_name = $_POST['sub_service_name'];
    $service_id = $_POST['service_id'];

    $update_query = "UPDATE tbl_sub_services SET sub_service = '$sub_service_name',services_id='$service_id' WHERE id = $sub_service_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        return true;
    } else {
        echo 'Failed to update service';
    }
} else {
    echo 'Invalid request';
}
?>
