<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_province WHERE disabled_status='enabled'");
if(mysqli_num_rows($fetch_query)>0){
    $data = "";
    foreach($fetch_query as $province){
        if($province['id']==$id){
            $data .= "<option value='$province[id]' selected >$province[province]</opiton>";
        }else{
            $data .= "<option value='$province[id]'>$province[province]</opiton>";
        }
    }
    echo $data;
}else{
    echo "<option>Id Not Found</option>";
}
?>