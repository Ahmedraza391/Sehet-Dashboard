<?php
include("connection.php");
$id = $_GET['id'];
$c_person = $_GET['c_person'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_employees WHERE id = '$id'");
if(mysqli_num_rows($check_id)>0){
    $update_query = mysqli_query($connection,"UPDATE tbl_employees SET emp_status='activate' WHERE id = '$id'");
    if($update_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('employees','$c_person','activate_employees','$date','$time')");
        echo "<script>alert('Employee Activate Successfully');window.location.href = 'employee_management.php'</script>";
    }else{
        echo "Error in Updating Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>