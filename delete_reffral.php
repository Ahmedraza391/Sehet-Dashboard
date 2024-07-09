<?php 
include("connection.php");
$id = $_POST['id'];
$delete_Query = mysqli_query($connection,"DELETE FROM tbl_reffrals WHERE id = '$id'");
if($delete_Query){
    echo "Reffral Deleted Successfully";
}else{
    echo "Failed to Delete Reffral";
}
?>