<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['id'];
    $service_name = $_POST['service'];

    $update_query = "UPDATE tbl_services SET service = '$service_name' WHERE id = $service_id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('manage_service','$_POST[c_person]','edit_manage_service','$date','$time')");
        echo 'Service Updated Successfully';
    } else {
        echo 'Failed to update service';
    }
} else {
    echo 'Invalid request';
}
?>
