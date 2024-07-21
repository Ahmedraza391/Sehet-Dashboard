<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_city WHERE province_id = '$id'");
$option = "";
foreach($fetch_query as $city){
    $option .= "<option value='{$city['id']}'>{$city['city']}</option>";
}
echo $option;
?>