<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "UPDATE tbl_patients SET disabled_status='enabled' WHERE patient_id ='$id'";
    $execute = mysqli_query($connection,$query);
    if($execute){
        echo "<script>alert('Patient Enabled Successfully');window.location.href='patient_management.php'</script>";
    }
} else {
    echo "<script>alert('No ID provided.');window.location.href='patient_management.php'</script>";
}

// Close the connection
$connection->close();
?>
