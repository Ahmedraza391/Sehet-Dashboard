<?php
// Include your database connection file
include("connection.php");
$name = mysqli_real_escape_string($connection, $_POST['patient_name']);
$attendent_name = mysqli_real_escape_string($connection, $_POST['attendent_name']);
$email = mysqli_real_escape_string($connection, $_POST['patient_email']);
$contact = mysqli_real_escape_string($connection, $_POST['patient_contact']);
$whatsapp = mysqli_real_escape_string($connection, $_POST['patient_whatsapp']);
$address = mysqli_real_escape_string($connection, $_POST['patient_address']);
$age = mysqli_real_escape_string($connection, $_POST['patient_age']);
$gender = mysqli_real_escape_string($connection, $_POST['patient_gender']);
$a_date = mysqli_real_escape_string($connection, $_POST['patient_admit_date']);
$d_date = mysqli_real_escape_string($connection, $_POST['patient_discharge_date']);
$province_id = mysqli_real_escape_string($connection, $_POST['patient_province']);
$city_id = mysqli_real_escape_string($connection, $_POST['patient_city']);
$area_id = mysqli_real_escape_string($connection, $_POST['patient_area']);
$refferal_id = mysqli_real_escape_string($connection, $_POST['patient_refferal']);
$panel_id = mysqli_real_escape_string($connection, $_POST['patient_panel']);
$staff_id = mysqli_real_escape_string($connection, $_POST['employee_staff']);
$service_id = mysqli_real_escape_string($connection, $_POST['patient_service']);
$payment_status = mysqli_real_escape_string($connection, $_POST['payment_status']);
$patient_rate = mysqli_real_escape_string($connection, $_POST['patient_rate']);
$staff_rate = mysqli_real_escape_string($connection, $_POST['staff_rate']);
$recovery = mysqli_real_escape_string($connection, $_POST['recovery']);
$running_bill = mysqli_real_escape_string($connection, $_POST['running_bill']);
$note = mysqli_real_escape_string($connection, $_POST['note']);
$changes_person = mysqli_real_escape_string($connection, $_POST['changes_person']);
$registration_date = date("Y-m-d H:i:s");

// Calculate total days and patient status
if (!empty($d_date)) {
    $datetime1 = new DateTime($a_date);
    $datetime2 = new DateTime($d_date);
    $interval = $datetime1->diff($datetime2);
    $total_days = $interval->days;
    $p_status = "Discharged";
} else {
    $total_days = 0;
    $p_status = "Admitted";
}

// Generate MR No
$mr_no = generateMRNo($connection);

// Insert query
$sql = "INSERT INTO tbl_patients (
            mr_no, 
            registration_date, 
            patient_name, 
            attendent_name, 
            patient_age, 
            patient_gender, 
            patient_contact, 
            patient_whatsapp, 
            patient_email, 
            patient_status, 
            patient_address, 
            patient_admit_date, 
            patient_discharge_date, 
            patient_total_days, 
            province_id, 
            city_id, 
            area_id, 
            refferal_id, 
            panel_id, 
            employee_id, 
            payment_status, 
            patient_rate, 
            staff_rate, 
            service_id, 
            recovery, 
            running_bill, 
            note, 
            changes_person
        ) VALUES (
            '$mr_no', 
            '$registration_date', 
            '$name', 
            '$attendent_name', 
            '$age', 
            '$gender', 
            '$contact', 
            '$whatsapp', 
            '$email', 
            '$p_status', 
            '$address', 
            '$a_date', 
            '$d_date', 
            '$total_days', 
            '$province_id', 
            '$city_id', 
            '$area_id', 
            '$refferal_id', 
            '$panel_id', 
            '$staff_id', 
            '$payment_status', 
            '$patient_rate', 
            '$staff_rate', 
            '$service_id', 
            '$recovery', 
            '$running_bill', 
            '$note', 
            '$changes_person'
        )";

if ($connection->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

// Close the connection
$connection->close();

function generateMRNo($connection) {
    $year = date('Y');
    $month = date('m');
    
    // Query to get the count of patients admitted this month
    $sql = "SELECT COUNT(*) AS count FROM tbl_patients WHERE YEAR(patient_admit_date) = $year AND MONTH(patient_admit_date) = $month";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    
    if ($row) {
        $count = $row['count'] + 1; // Increment the count to get the next patient number
    } else {
        $count = 1; // If no records found, start with 1
    }
    
    // Generate MR No
    $mr_no = sprintf("%04d-%02d-%03d", $year, $month, $count);
    
    return $mr_no;
}
?>
