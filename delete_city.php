<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $city_id = $_POST['id'];

    $delete_query = "DELETE FROM tbl_city WHERE id = $city_id";
    $result = mysqli_query($connection, $delete_query);

    if ($result) {
        echo 'City Deleted Successfully';
    } else {
        echo 'Failed to Delete City';
    }
} else {
    echo 'Invalid request';
}
?>
