<?php
include("connection.php");
$id = $_POST['id'];
$p_id = $_POST['p_id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_city WHERE province_id = '$p_id'");
if(mysqli_num_rows($fetch_query)>0){
    $data = "";
    foreach($fetch_query as $city){
        if($city['id']==$id){
            $data .= "<option value='$city[id]' selected >$city[city]</opiton>";
        }else{
            $data .= "<option value='$city[id]'>$city[city]</opiton>";
        }
    }
    echo $data;
}else{
    echo "<option>Cities Not Found</option>";
}
?>