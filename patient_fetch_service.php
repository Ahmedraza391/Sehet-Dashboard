<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_services WHERE id = '$id'");
if(mysqli_num_rows($fetch_query)>0){
    $fetch = mysqli_fetch_assoc($fetch_query);
    echo "$fetch[service]";
}else{
    echo "Id Not Found";
}
?>