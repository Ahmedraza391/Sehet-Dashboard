<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_city WHERE id = '$id' AND disabled_status = 'enabled'");
if(mysqli_num_rows($fetch_query)>0){
    $fetch = mysqli_fetch_assoc($fetch_query);
    echo "$fetch[city]";
}else{
    echo "Id Not Found";
}
?>