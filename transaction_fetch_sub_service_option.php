<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_extra_services WHERE sub_services_id = '$id' AND disabled_status = 'enabled' AND status='available'");
$option = "";
if(mysqli_num_rows($fetch_query)>0){
    foreach($fetch_query as $service){
        $option .= "<option value='{$service['id']}'>{$service['extra_service']}</option>";
    }
}else{
    $option .= "<option>Service Sub Head Not Found</option>";

}
echo $option;
?>