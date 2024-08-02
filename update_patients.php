<?php
// Include database connection
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $edit_changes_person = $_POST['edit_changes_person'];
    $edit_patient_name = $_POST['edit_patient_name'];
    $edit_attendent_name = $_POST['edit_attendent_name'];
    $edit_patient_email = $_POST['edit_patient_email'];
    $edit_patient_contact = $_POST['edit_patient_contact'];
    $edit_patient_whatsapp = $_POST['edit_patient_whatsapp'];
    $edit_patient_address = $_POST['edit_patient_address'];
    $edit_patient_age = $_POST['edit_patient_age'];
    $edit_patient_gender = $_POST['edit_patient_gender'];
    $edit_patient_admit_date = $_POST['edit_patient_admit_date'];
    $edit_patient_discharge_date = $_POST['edit_patient_discharge_date'];
    $edit_patient_province = $_POST['edit_patient_province'];
    $edit_patient_city = $_POST['edit_patient_city'];
    $edit_patient_area = $_POST['edit_patient_area'];
    $edit_patient_refferal = $_POST['edit_patient_refferal'];
    $edit_patient_panel = $_POST['edit_patient_panel'];
    $edit_employee_staff = $_POST['edit_employee_staff'];
    $edit_patient_service = $_POST['edit_patient_service'];
    $edit_payment_status = $_POST['edit_payment_status'];
    $edit_patient_rate = $_POST['edit_patient_rate'];
    $edit_staff_rate = $_POST['edit_staff_rate'];
    $edit_recovery = $_POST['edit_recovery'];
    $edit_running_bill = $_POST['edit_running_bill'];
    $edit_note = $_POST['edit_note'];
    $patient_id = $_POST['edit_patient_id']; // Assuming you have patient_id

    // Calculate total days and patient status
    if (!empty($edit_patient_discharge_date)) {
        $datetime1 = new DateTime($edit_patient_admit_date);
        $datetime2 = new DateTime($edit_patient_discharge_date);
        $interval = $datetime1->diff($datetime2);
        $total_days = $interval->days;
        $edit_patient_status = "Discharged";
    } else {
        $total_days = 0;
        $edit_patient_status = "Admitted";
    }
    // Update the patient data in the database
    $sql = "UPDATE tbl_patients SET 
            patient_name = '$edit_patient_name',
            attendent_name = '$edit_attendent_name',
            patient_email = '$edit_patient_email',
            patient_contact = '$edit_patient_contact',
            patient_whatsapp = '$edit_patient_whatsapp',
            patient_address = '$edit_patient_address',
            patient_age = '$edit_patient_age',
            patient_gender = '$edit_patient_gender',
            patient_status = '$edit_patient_status',
            patient_admit_date = '$edit_patient_admit_date',
            patient_discharge_date = '$edit_patient_discharge_date',
            patient_total_days = '$total_days',
            province_id = '$edit_patient_province',
            city_id = '$edit_patient_city',
            area_id = '$edit_patient_area',
            refferal_id = '$edit_patient_refferal',
            panel_id = '$edit_patient_panel',
            employee_id = '$edit_employee_staff',
            service_id = '$edit_patient_service',
            payment_status = '$edit_payment_status',
            patient_rate = '$edit_patient_rate',
            staff_rate = '$edit_staff_rate',
            recovery = '$edit_recovery',
            running_bill = '$edit_running_bill',
            note = '$edit_note',
            changes_person = '$edit_changes_person'
            WHERE patient_id = $patient_id";

    if (mysqli_query($connection, $sql)) {
        echo 'Patient data updated successfully!';
    } else {
        echo 'Error: ' . $sql . '<br>' . mysqli_error($connection);
    }

    // Close the connection
    mysqli_close($connection);
}
