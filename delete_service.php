<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['id'];

    $delete_query = "DELETE FROM tbl_services WHERE id = $service_id";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        echo 'Service Deleted Successfully';
    } else {
        echo 'Failed to delete service';
    }
} else {
    echo 'Invalid request';
}
?>
