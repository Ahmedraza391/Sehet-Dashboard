<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $province_id = $_POST['id'];
    $province_name = $_POST['province'];

    $update_query = "UPDATE tbl_province SET province = '$province_name' WHERE id = $province_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('province','$_POST[c_person]','edit_province','$date','$time')");
        echo 'Province Updated Successfully';
    } else {
        echo 'Failed to Update Province';
    }
} else {
    echo 'Invalid request';
}
?>
