<?php
include("connection.php");
$query = mysqli_query($connection,"SELECT * FROM tbl_area WHERE city_id = '$_POST[c_id]'");
$id = $_POST['id'];
$option ="";
if(mysqli_num_rows($query)>0){
    foreach($query as $data ){
        if($data['id']==$id){
            $option .= "<option selected value='$data[id]'>$data[area]</option>";
        }else{
            $option .= "<option value='$data[id]'>$data[area]</option>";
        }
    }
}else{
    $option .= "<option>Areas Not Found</option>";
}
echo $option;
?>