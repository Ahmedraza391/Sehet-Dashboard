<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sub_service_id = $_POST['id'];

    $delete_query = "DELETE FROM tbl_sub_services WHERE id = $sub_service_id";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        return true;
    } else {
        echo 'Failed to delete service';
    }
} else {
    echo 'Invalid request';
}
?>
