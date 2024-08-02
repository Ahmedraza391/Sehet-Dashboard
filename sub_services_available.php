<?php
include("connection.php");
$id = $_GET['id'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_sub_services WHERE id = $id");
$c_person = $_GET['c_person'];

if(mysqli_num_rows($check_id)>0){
    $update_query = mysqli_query($connection,"UPDATE tbl_sub_services SET status='available' WHERE id = $id");
    if($update_query){
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('service_main_head','$c_person','available_service_main_head','$date','$time')");
        echo "<script>alert('Service Main Head Available Successfully');window.location.href = 'services.php'</script>";
    }else{
        echo "Error in Setting Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>