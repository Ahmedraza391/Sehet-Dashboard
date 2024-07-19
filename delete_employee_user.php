<?php 
include("connection.php");
$id = $_POST['id'];
$delete_Query = mysqli_query($connection,"DELETE FROM tbl_employee_users WHERE user_id = '$id'");
if($delete_Query){
    echo "Employee User Deleted Successfully";
}else{
    echo "Failed to Delete Employee User";
}
?>