<?php
include("connection.php");
$id = $_GET['id'];
$check_id_exists = mysqli_query($connection, "SELECT * FROM  tbl_patients WHERE patient_id = '$id'");
if (mysqli_num_rows($check_id_exists) > 0) {
    $Cperson = $_GET['c_person'];
    $query = "UPDATE tbl_patients SET disabled_status='disabled' WHERE patient_id ='$id'";
    $execute = mysqli_query($connection, $query);
    if ($execute) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection, "INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('patients','$Cperson','disable_patients','$date','$time')");
        echo "<script>alert('Patient Disabled Successfully');window.location.href='patient_management.php'</script>";
    }
} else {
    echo '<script>
            alert("Id Doesn\'t Matched.");
            window.location.href = "patient_management.php";
          </script>';
}

// Close the connection
$connection->close();
