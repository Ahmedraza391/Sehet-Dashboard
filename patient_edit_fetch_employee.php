<?php
include("connection.php");
$id = $_POST['id'];
$fetch_query = mysqli_query($connection,"SELECT * FROM tbl_employees WHERE emp_designation != 'admin' AND emp_status = 'activate'");
if(mysqli_num_rows($fetch_query)>0){
    $data = "";
    foreach($fetch_query as $option){
        if($option['emp_id']==$id){
            $data .= "<option value='$option[emp_id]' selected >$option[emp_name] ---- $option[emp_designation]</opiton>";
        }else{
            $data .= "<option value='$option[emp_id]'>$option[emp_name] ---- $option[emp_designation]</opiton>";
        }
    }
    echo $data;
}else{
    echo "Id Not Found";
}
?>