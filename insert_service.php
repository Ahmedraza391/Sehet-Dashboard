<?php
    include("connection.php");
    $service = $_POST['service'];
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_services(service)VALUES('$service')");
    if($insert_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('manage_service','$_POST[c_person]','add_manage_service','$date','$time')");
        return true;
    }
?>