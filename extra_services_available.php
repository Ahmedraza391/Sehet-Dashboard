<?php
include("connection.php");
$id = $_GET['id'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_extra_services WHERE id = $id");
if(mysqli_num_rows($check_id)>0){
    $update_query = mysqli_query($connection,"UPDATE tbl_extra_services SET status='available' WHERE id = $id");
    if($update_query){
        echo "<script>alert('Extra-Service Available Successfully');window.location.href = 'services.php'</script>";
    }else{
        echo "Error in Setting Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>