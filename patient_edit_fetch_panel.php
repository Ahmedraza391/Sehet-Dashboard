<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_panel WHERE status = 'activate'");
if(mysqli_num_rows($fetch_query)>0){
    $data = "";
    foreach($fetch_query as $option){
        if($option['id']==$id){
            $data .= "<option value='$option[id]' selected >$option[company]</opiton>";
        }else{
            $data .= "<option value='$option[id]'>$option[company]</opiton>";
        }
    }
    echo $data;
}else{
    echo "Id Not Found";
}
?>