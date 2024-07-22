<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_services WHERE status = 'available'");
if(mysqli_num_rows($fetch_query)>0){
    $data = "";
    foreach($fetch_query as $option){
        if($option['id']==$id){
            $data .= "<option value='$option[id]' selected >$option[service]</opiton>";
        }else{
            $data .= "<option value='$option[id]'>$option[service]</opiton>";
        }
    }
    echo $data;
}else{
    echo "Id Not Found";
}
?>