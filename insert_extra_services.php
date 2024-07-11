<?php
    include("connection.php");
    $extra_service = $_POST['extra_service'];
    $extra_service_price = $_POST['extra_service_price'];
    $s_s_id = $_POST['sub_service_id'];
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_extra_services(extra_service,extra_service_price,sub_services_id)VALUES('$extra_service','$extra_service_price','$s_s_id')");
    if($insert_query){
        echo "Extra Service Added Successfully";
    }else{
        echo "Failed to Add Extra Service";
    }
?>