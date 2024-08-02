<?php
include("connection.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security (to prevent SQL injection)
    $emp_id = mysqli_real_escape_string($connection, $_POST['emp_id']);
    $emp_name = mysqli_real_escape_string($connection, $_POST['emp_name']);
    $emp_father_name = mysqli_real_escape_string($connection, $_POST['emp_father_name']);
    $emp_email = mysqli_real_escape_string($connection, $_POST['emp_email']);
    $emp_contact = mysqli_real_escape_string($connection, $_POST['emp_contact']);
    $emp_nic = mysqli_real_escape_string($connection, $_POST['emp_nic']);
    $emp_dob = mysqli_real_escape_string($connection, $_POST['emp_dob']);
    $emp_designation = mysqli_real_escape_string($connection, $_POST['emp_designation']);

    // Checkbox handling
    $pages = isset($_POST['pages']) ? $_POST['pages'] : [];
    $pages_string = implode(", ", $pages);

    // SQL query to insert data into database
    $sql = "INSERT INTO tbl_employees (emp_id,emp_name, emp_father_name, emp_email, emp_contact, emp_nic, emp_dob, emp_designation)
            VALUES ('$emp_id','$emp_name', '$emp_father_name', '$emp_email', '$emp_contact', '$emp_nic', '$emp_dob', '$emp_designation')";

    if ($connection->query($sql) === TRUE) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('employees','$_POST[add_employee_changes_person]','add_employees','$date','$time')");
        echo "Employee added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
} else {
    echo "Error: Invalid request.";
}

// Close connection
$connection->close();
?>