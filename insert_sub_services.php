<?php
    include("connection.php");
    $sub_service = $_POST['sub_service'];
    $s_id = $_POST['service_id'];
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_sub_services(sub_service,services_id)VALUES('$sub_service','$s_id')");
    if($insert_query){
        return true;
    }
?>