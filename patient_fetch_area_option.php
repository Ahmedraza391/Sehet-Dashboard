<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_area WHERE city_id = '$id' AND disabled_status='enabled'");
$option = "";
foreach($fetch_query as $area){
    $option .= "<option value='{$area['id']}'>{$area['area']}</option>";
}
echo $option;
?>