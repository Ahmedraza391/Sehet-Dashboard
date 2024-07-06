<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['id'];
    $service_name = $_POST['service'];

    $update_query = "UPDATE tbl_services SET service = '$service_name' WHERE id = $service_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo 'Service Updated Successfully';
    } else {
        echo 'Failed to update service';
    }
} else {
    echo 'Invalid request';
}
?>
