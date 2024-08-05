<?php
include("connection.php");
// Collect form data
$emp_id = $_POST['edit_emp_user_id'];
$name = $_POST['edit_emp_user_name'];
$father_name = $_POST['edit_emp_user_father_name'];
$email = $_POST['edit_emp_user_email'];
$password = $_POST['edit_emp_user_password'];
$contact = $_POST['edit_emp_user_contact'];
$nic = $_POST['edit_emp_user_nic'];
$dob = $_POST['edit_emp_user_dob'];
$pages_access = implode(',', $_POST['edit_pages_access']);

// Update database (example SQL)
$sql = "UPDATE tbl_users SET user_name=?, user_father_name=?, user_email=?, user_password=?, user_contact=?, user_nic=?, user_dob=?, pages_access=? WHERE user_id=?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ssssssssi", $name, $father_name, $email, $password, $contact, $nic, $dob, $pages_access, $emp_id);

if ($stmt->execute()) {
    date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('users','$_POST[edit_user_changes_person]','edit_users','$date','$time')");
    echo json_encode(["status" => "success", "message" => "User updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error updating record: " . $stmt->error]);
}

$stmt->close();
$connection->close();
?>
