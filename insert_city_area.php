<?php
    include("connection.php");
    $city_area = mysqli_real_escape_string($connection, $_POST['city_area']);
    $c_id = mysqli_real_escape_string($connection, $_POST['city_id']);
    $insert_query = mysqli_query($connection,"INSERT INTO tbl_area(area,city_id)VALUES('$city_area','$c_id')");
    if($insert_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('area','$_POST[add_area_changes_person]','add_area','$date','$time')");
        echo "Area Inserted Successfully";
    }else{
        echo "Error in Insertation of Area";
    }
?>