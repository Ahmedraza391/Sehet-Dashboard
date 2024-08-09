<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $c_person = $_GET['c_person'];
    $query = "UPDATE tbl_vendor SET disabled_status='enabled' WHERE vendor_id ='$id'";
    $execute = mysqli_query($connection,$query);
    if($execute){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('vendors','$c_person','enable_vendors','$date','$time')");
        echo "<script>alert('Vendor Enabled Successfully');window.location.href='vendor_management.php'</script>";
    }
} else {
    echo "<script>alert('No ID provided.');window.location.href='vendor_management.php'</script>";
}

// Close the connection
$connection->close();
?>
