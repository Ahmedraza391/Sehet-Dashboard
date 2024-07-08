<?php 
include("connection.php");
$id = $_POST['id'];
$query = mysqli_query($connection, "SELECT * FROM tbl_city_capital");

$options = "";
foreach($query as $option) {
    if($option['id'] == $id) {
        $options .= "<option value='{$option['id']}' selected>{$option['city_capital']}</option>";
    } else {
        $options .= "<option value='{$option['id']}'>{$option['city_capital']}</option>";
    }
}

echo $options;
?>
