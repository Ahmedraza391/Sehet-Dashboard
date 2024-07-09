<?php
    include("connection.php");
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $p_id = mysqli_real_escape_string($connection, $_POST['province_id']);
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_city(city,province_id)VALUES('$city','$p_id')");
    if($insert_query){
        echo "City Inserted Successfully";
    }else{
        echo "Error in Insertation of City";
    }
?>