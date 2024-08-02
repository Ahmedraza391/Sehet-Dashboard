<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $c_person = $_GET['c_person'];
    $query = "UPDATE tbl_area SET disabled_status='enabled' WHERE id ='$id'";
    $execute = mysqli_query($connection,$query);
    if($execute){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('area','$c_person','enable_area','$date','$time')");
        echo "<script>alert('Area Enabled Successfully');window.location.href='address_management.php'</script>";
    }
} else {
    echo "<script>alert('No ID provided.');window.location.href='address_management.php'</script>";
}

// Close the connection
$connection->close();
?>
