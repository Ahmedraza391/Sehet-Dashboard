<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['city_id'];
    $city = $_POST['city'];
    $province = $_POST['province_id'];

    $update_query = "UPDATE tbl_city SET city = '$city',province_id='$province' WHERE id = $id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('city','$_POST[edit_city_changes_person]','edit_city','$date','$time')");
        echo "City Successfully Updated";
    } else {
        echo 'Failed to Updates City';
    }
} else {
    echo 'Invalid request';
}
?>
