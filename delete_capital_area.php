<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $delete_query = "DELETE FROM tbl_area WHERE id = $id";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        echo "Capital Area Deleted Successfully";
    } else {
        echo 'Failed to Capital Area';
    }
} else {
    echo 'Invalid request';
}
?>
