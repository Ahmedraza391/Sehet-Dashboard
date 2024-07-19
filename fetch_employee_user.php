<?php
include("connection.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM tbl_employees WHERE emp_id = '$id' AND emp_status = 'activate'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
        echo json_encode($employee);
    } else {
        echo json_encode(null);
    }
}
?>
