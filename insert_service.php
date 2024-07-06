<?php
    include("connection.php");
    $service = $_POST['service'];
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_services(service)VALUES('$service')");
    if($insert_query){
        return true;
    }
?>