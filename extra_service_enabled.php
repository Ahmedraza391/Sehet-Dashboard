<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $c_person = $_GET['c_person'];
    $query = "UPDATE tbl_extra_services SET disabled_status='enabled' WHERE id ='$id'";
    $execute = mysqli_query($connection,$query);
    if($execute){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('service_sub_head','$c_person','enable_service_sub_head','$date','$time')");
        echo "<script>alert('Service Sub Head Enabled Successfully');window.location.href='services.php'</script>";
    }
} else {
    echo "<script>alert('No ID provided.');window.location.href='services.php'</script>";
}

// Close the connection
$connection->close();
?>
