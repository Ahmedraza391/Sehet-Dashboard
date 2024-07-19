<?php
    // Include your database connection file
    include("connection.php");
    $id = $_POST['emp_user_id'];
    // Initialize variables from POST data
    $name = mysqli_real_escape_string($connection, $_POST['emp_user_name']);
    $father_name = mysqli_real_escape_string($connection, $_POST['emp_user_father_name']);
    $email = mysqli_real_escape_string($connection, $_POST['emp_user_email']);
    $password = mysqli_real_escape_string($connection, $_POST['emp_user_password']);
    $contact = mysqli_real_escape_string($connection, $_POST['emp_user_contact']);
    $nic = mysqli_real_escape_string($connection, $_POST['emp_user_nic']);
    $dob = mysqli_real_escape_string($connection, $_POST['emp_user_dob']);
    
    // Handle pages access checkboxes
    if(isset($_POST['pages_access'])) {
        $pages = $_POST['pages_access'];
        $access_pages = implode(',', $pages); // Assuming pages_access is stored as comma-separated values
    } else {
        $access_pages = ''; // Handle case where no pages are selected
    }

    // Create SQL insert query
    $insert_query = "INSERT INTO tbl_employee_users (user_name, user_father_name, user_email, user_password, user_contact, user_nic, user_dob, pages_access) VALUES ('$name', '$father_name', '$email', '$password', '$contact', '$nic', '$dob', '$access_pages')";

    // Execute query
    $execute_query = mysqli_query($connection, $insert_query);

    if($execute_query) {
        $update_status = mysqli_query($connection,"UPDATE tbl_employees SET registration_status = 'registered' WHERE emp_id = '$id'");
        echo "Employee user added successfully.";
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    // Close database connection
    mysqli_close($connection);
?>
