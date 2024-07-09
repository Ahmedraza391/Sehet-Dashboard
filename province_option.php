<?php 
include("connection.php");
$id = $_POST['id'];
$query = mysqli_query($connection, "SELECT * FROM tbl_province");

$options = "";
foreach($query as $option) {
    if($option['id'] == $id) {
        $options .= "<option value='{$option['id']}' selected>{$option['province']}</option>";
    } else {
        $options .= "<option value='{$option['id']}'>{$option['province']}</option>";
    }
}

echo $options;
?>
