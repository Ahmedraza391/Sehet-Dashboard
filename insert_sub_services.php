<?php
    include("connection.php");
    $sub_service = $_POST['sub_service'];
    $s_id = $_POST['service_id'];
    $sub_service_price = $_POST['sub_service_price'];
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_sub_services(sub_service,sub_service_price,services_id)VALUES('$sub_service','$sub_service_price','$s_id')");
    if($insert_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('service_main_head','$_POST[service_main_changes_person]','add_service_main_head','$date','$time')");
        echo "Sub-Services Inserted Successfully";
    }else{
        echo "Error In Inserting Sub-Services";
    }
?>