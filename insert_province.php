<?php
include("connection.php");
    $province = $_POST['province'];
    if(isset($province)){
        $query = mysqli_query($connection,"INSERT INTO tbl_province (province)VALUES('$province')");
        if($query){
            date_default_timezone_set('Asia/Karachi');
            $date = date('Y-m-d');
            $time = date('h:i:s');
            $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('province','$_POST[c_person]','add_province','$date','$time')");
            echo "Province Added Successfully";
        }
    }else{
        echo "Province name is empty";
    }
?>
