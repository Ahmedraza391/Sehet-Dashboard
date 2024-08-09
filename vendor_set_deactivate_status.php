<?php
include("connection.php");
$id = $_GET['id'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_vendor WHERE vendor_id = $id");
if(mysqli_num_rows($check_id)>0){
    $c_person = $_GET['c_person'];
    $update_query = mysqli_query($connection,"UPDATE tbl_vendor SET status='deactivate' WHERE vendor_id = $id");
    if($update_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('vendors','$c_person','deactivate_vendors','$date','$time')");
        echo "<script>alert('Vendor Deactivate Successfully');window.location.href = 'vendor_management.php'</script>";
    }else{
        echo "Error in Updating Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>