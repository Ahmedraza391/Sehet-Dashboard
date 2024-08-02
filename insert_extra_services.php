<?php
    include("connection.php");
    $extra_service = $_POST['extra_service'];
    $extra_service_price = $_POST['extra_service_price'];
    $s_s_id = $_POST['sub_service_id'];
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_extra_services(extra_service,extra_service_price,sub_services_id)VALUES('$extra_service','$extra_service_price','$s_s_id')");
    if($insert_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('service_sub_head','$_POST[service_sub_changes_person]','add_service_sub_head','$date','$time')");
        echo "Extra Service Added Successfully";
    }else{
        echo "Failed to Add Extra Service";
    }
?>