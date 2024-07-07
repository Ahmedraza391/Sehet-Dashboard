<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $extra_service_id = $_POST['id'];

    $delete_query = "DELETE FROM tbl_extra_services WHERE id = $extra_service_id";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        echo "Extra Service Deleted Successfully";
    } else {
        echo 'Failed to delete service';
    }
} else {
    echo 'Invalid request';
}
?>
