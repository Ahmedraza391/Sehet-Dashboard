<?php
    include("connection.php");
    $city_area = mysqli_real_escape_string($connection, $_POST['city_area']);
    $c_id = mysqli_real_escape_string($connection, $_POST['city_id']);
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_area(area,city_id)VALUES('$city_area','$c_id')");
    if($insert_query){
        echo "Area Inserted Successfully";
    }else{
        echo "Error in Insertation of Area";
    }
?>