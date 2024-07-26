<?php
include("connection.php");
$id = $_GET['id'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_users WHERE user_id = '$id'");
if(mysqli_num_rows($check_id)>0){
    $update_query = mysqli_query($connection,"UPDATE tbl_users SET user_status='deactivate' WHERE user_id = '$id'");
    if($update_query){
        echo "<script>alert('User Deactivate Successfully');window.location.href = 'user_management.php'</script>";
    }else{
        echo "Error in Updating Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>