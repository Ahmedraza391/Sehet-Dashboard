<?php
include('connection.php');

// Sanitize and validate input
$id = mysqli_real_escape_string($connection, $_POST['tbl_id']);
$name = mysqli_real_escape_string($connection, $_POST['edit_emp_name']);
$father_name = mysqli_real_escape_string($connection, $_POST['edit_emp_father_name']);
$email = mysqli_real_escape_string($connection, $_POST['edit_emp_email']);
$contact = mysqli_real_escape_string($connection, $_POST['edit_emp_contact']);
$nic = mysqli_real_escape_string($connection, $_POST['edit_emp_nic']);
$dob = mysqli_real_escape_string($connection, $_POST['edit_emp_dob']);
$designation = mysqli_real_escape_string($connection, $_POST['edit_emp_designation']);

$query = "UPDATE tbl_employees SET
            emp_name = '$name',
            emp_father_name = '$father_name',
            emp_email = '$email',
            emp_contact = '$contact',
            emp_nic = '$nic',
            emp_dob = '$dob',
            emp_designation = '$designation'
          WHERE id = '$id'";

if (mysqli_query($connection, $query)) {
    echo "Employee updated successfully.";
} else {
    echo "Error updating employee: " . mysqli_error($connection);
}
?>
