<?php
include("connection.php");
$id = $_GET['id'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_employees WHERE emp_id = '$id'");
if(mysqli_num_rows($check_id)>0){
    $update_query = mysqli_query($connection,"UPDATE tbl_employees SET emp_status='deactivate' WHERE emp_id = '$id'");
    if($update_query){
        echo "<script>alert('Employee Deactivate Successfully');window.location.href = 'employee_management.php'</script>";
    }else{
        echo "Error in Updating Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>