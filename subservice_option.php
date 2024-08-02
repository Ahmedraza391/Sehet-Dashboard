<?php 
include("connection.php");
$id = $_POST['id'];
$query = mysqli_query($connection, "SELECT * FROM tbl_services WHERE disabled_status='enabled'");

$options = "";
foreach($query as $option) {
    if($option['id'] == $id) {
        $options .= "<option value='{$option['id']}' selected>{$option['service']}</option>";
    } else {
        $options .= "<option value='{$option['id']}'>{$option['service']}</option>";
    }
}

echo $options;
?>
