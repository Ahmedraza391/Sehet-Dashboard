<?php 
include("connection.php");
$id = $_POST['id'];
$delete_Query = mysqli_query($connection,"DELETE FROM tbl_employees WHERE emp_id = '$id'");
if($delete_Query){
    echo "Employee Deleted Successfully";
}else{
    echo "Failed to Delete Employee";
}
?>