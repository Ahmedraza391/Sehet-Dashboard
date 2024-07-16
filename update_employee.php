<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['emp_id'];
    $name = $_POST['edit_emp_name'];
    $father_name = $_POST['edit_emp_father_name'];
    $email = $_POST['edit_emp_email'];
    $contact = $_POST['edit_emp_contact'];
    $nic = $_POST['edit_emp_nic'];
    $dob = $_POST['edit_emp_dob'];
    $designation = $_POST['edit_emp_designation'];

    $query = "UPDATE tbl_employees SET
                emp_name = '$name',
                emp_father_name = '$father_name',
                emp_email = '$email',
                emp_contact = '$contact',
                emp_nic = '$nic',
                emp_dob = '$dob',
                emp_designation = '$designation'
              WHERE emp_id = '$id'";

    if (mysqli_query($connection, $query)) {
        echo "Employee updated successfully.";
    } else {
        echo "Error updating employee: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>
