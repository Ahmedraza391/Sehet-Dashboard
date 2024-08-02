<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['area_id'];
    $area = $_POST['area_name'];
    $city_capital_id = $_POST['city_id'];

    $update_query = "UPDATE tbl_area SET area = '$area',city_id='$city_capital_id' WHERE id = $id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('area','$_POST[edit_area_changes_person]','edit_area','$date','$time')");
        echo "Successfully Updated";
    } else {
        echo 'Failed to Update Area';
    }
} else {
    echo 'Invalid request';
}
?>
