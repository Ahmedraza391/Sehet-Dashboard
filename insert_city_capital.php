<?php
    include("connection.php");
    $city_capital = mysqli_real_escape_string($connection, $_POST['city_capitial']);
    $c_id = mysqli_real_escape_string($connection, $_POST['city_id']);
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_city_capital(city_capital,city_id)VALUES('$city_capital','$c_id')");
    if($insert_query){
        echo "City Inserted Successfully";
    }else{
        echo "Error in Insertation of City";
    }
?>