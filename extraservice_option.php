<?php 
include("connection.php");
$id = $_POST['id'];
$query = mysqli_query($connection, "SELECT * FROM tbl_sub_services");

$options = "";
foreach($query as $option) {
    if($option['id'] == $id) {
        $options .= "<option value='{$option['id']}' selected>{$option['sub_service']}</option>";
    } else {
        $options .= "<option value='{$option['id']}'>{$option['sub_service']}</option>";
    }
}

echo $options;
?>
