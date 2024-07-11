<?php
include("connection.php");
$id = $_GET['id'];
$check_id = mysqli_query($connection,"SELECT * FROM tbl_refferals WHERE id = $id");
if(mysqli_num_rows($check_id)>0){
    $update_query = mysqli_query($connection,"UPDATE tbl_refferals SET status='hide' WHERE id = $id");
    if($update_query){
        echo "<script>alert('Refferal Hide Successfully');window.location.href = 'refferals_management.php'</script>";
    }else{
        echo "Error in Updating Status";
    }
}else{
    echo "<script>window.location.href = 'error_page.php'</script>";
}

?>