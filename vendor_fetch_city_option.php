<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_city WHERE province_id = '$id' AND disabled_status = 'enabled'");
$option = "";
if(mysqli_num_rows($fetch_query)>0){
    foreach($fetch_query as $city){
        $option .= "<option value='{$city['id']}'>{$city['city']}</option>";
    }
}else{
    $option .= "<option>Cities Not Found</option>";

}
echo $option;
?>