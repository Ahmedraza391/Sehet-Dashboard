<?php
include("connection.php");
$id = $_POST['id'];
$city_id = $_POST['c_id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_area WHERE city_id = '$city_id'");
if(mysqli_num_rows($fetch_query)>0){
    $data = "";
    foreach($fetch_query as $area){
        if($area['id']==$id){
            $data .= "<option value='$area[id]' selected >$area[area]</opiton>";
        }else{
            $data .= "<option value='$area[id]'>$area[area]</opiton>";
        }
    }
    echo $data;
}else{
    echo "Id Not Found";
}
?>