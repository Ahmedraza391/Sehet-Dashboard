<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $province_id = $_POST['id'];

    $delete_query = "DELETE FROM tbl_province WHERE id = $province_id";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        echo 'Province Deleted Successfully';
    } else {
        echo 'Failed to Delete Province';
    }
} else {
    echo 'Invalid request';
}
?>
