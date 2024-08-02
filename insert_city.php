<?php
    include("connection.php");
    $city = mysqli_real_escape_string($connection, $_POST['city']);
    $p_id = mysqli_real_escape_string($connection, $_POST['province_id']);
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_city(city,province_id)VALUES('$city','$p_id')");
    if($insert_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('city','$_POST[add_city_changes_person]','add_city','$date','$time')");
        echo "City Inserted Successfully";
    }else{
        echo "Error in Insertation of City";
    }
?>