<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $delete_query = "DELETE FROM tbl_city_capital WHERE id = $id";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        echo "City Capital Deleted Successfully";
    } else {
        echo 'Failed to delete service';
    }
} else {
    echo 'Invalid request';
}
?>
