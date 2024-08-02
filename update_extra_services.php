<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $extra_service_id = $_POST['extra_service_id'];
    $extra_service_name = $_POST['extra_service_name'];
    $extra_service_price = $_POST['extra_service_price'];
    $sub_service_id = $_POST['sub_service_id'];

    $update_query = "UPDATE tbl_extra_services SET extra_service = '$extra_service_name',extra_service_price='$extra_service_price',sub_services_id='$sub_service_id' WHERE id = $extra_service_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('service_sub_head','$_POST[edit_service_sub_changes_person]','edit_service_sub_head','$date','$time')");
        echo "Extra-Service Updated Successfully";
    } else {
        echo 'Failed to Update Extra-Service';
    }
} else {
    echo 'Invalid request';
}
?>
