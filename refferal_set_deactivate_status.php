<?php
include("connection.php");
$id = $_GET['id'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_refferals WHERE id = $id");
if(mysqli_num_rows($check_id)>0){
    $c_person = $_GET['c_person'];
    $update_query = mysqli_query($connection,"UPDATE tbl_refferals SET status='deactivate' WHERE id = $id");
    if($update_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('refferals','$c_person','deactivate_refferals','$date','$time')");
        echo "<script>alert('Refferal Deactivate Successfully');window.location.href = 'refferals_management.php'</script>";
    }else{
        echo "Error in Updating Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>