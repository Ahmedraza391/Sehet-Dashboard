<?php 
include("connection.php");
$id = $_POST['id'];
$delete_Query = mysqli_query($connection,"DELETE FROM tbl_refferals WHERE id = '$id'");
if($delete_Query){
    echo "Refferal Deleted Successfully";
}else{
    echo "Failed to Delete Refferal";
}
?>