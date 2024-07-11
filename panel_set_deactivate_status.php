<?php
include("connection.php");
$id = $_GET['id'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_panel WHERE id = $id");
if(mysqli_num_rows($check_id)>0){
    $update_query = mysqli_query($connection,"UPDATE tbl_panel SET status='deactivate' WHERE id = $id");
    if($update_query){
        echo "<script>alert('Panel Deactivate Successfully');window.location.href = 'panel_management.php'</script>";
    }else{
        echo "Error in Updating Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>