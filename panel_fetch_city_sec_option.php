<?php
include("connection.php");
$query = mysqli_query($connection,"SELECT * FROM tbl_city");
$id = $_POST['id'];
$option ="";
foreach($query as $data ){
    if($data['id']==$id){
        $option .= "<option selected value='$data[id]'>$data[city]</option>";
    }else{
        $option .= "<option value='$data[id]'>$data[city]</option>";
    }
}
echo $option;
?>