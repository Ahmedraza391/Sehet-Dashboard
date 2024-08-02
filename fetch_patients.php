<?php
include 'connection.php';

$query = "SELECT * FROM tbl_patients";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
            $output .= "<td class='text-center'>{$data['mr_no']}</td>";
            $output .= "<td class='text-left'>{$data['patient_name']}</td>";
            $output .= "<td class='text-left'>{$data['patient_contact']}</td>";
            $output .= "<td class='text-center'>{$data['patient_status']}</td>";
            $output .= "<td class='text-center'>";
                $payment_status = "";
                if($data['payment_status']=="r_from_patient"){
                    $payment_status = "Recovery From Patient";
                }else if($data['payment_status']=="r_from_panel"){
                    $payment_status = "Recovery From Panel";
                }else if($data['payment_status']=="zakat_donation"){
                    $payment_status = "Zakat Donations";
                }else{
                    $payment_status = "Other";
                }
                $output .= "<button class='btn btn-primary view-patient btn-sm' 
                    data-registration_date='{$data['registration_date']}' 
                    data-mr_no='{$data['mr_no']}' 
                    data-id='{$data['patient_id']}' 
                    data-name='{$data['patient_name']}' 
                    data-attendent_name='{$data['attendent_name']}' 
                    data-email='{$data['patient_email']}' 
                    data-contact='{$data['patient_contact']}' 
                    data-whatsapp='{$data['patient_whatsapp']}' 
                    data-patient_status='{$data['patient_status']}' 
                    data-age='{$data['patient_age']}' 
                    data-gender='{$data['patient_gender']}' 
                    data-ad_date='{$data['patient_admit_date']}' 
                    data-dis_date='{$data['patient_discharge_date']}' 
                    data-total_days='{$data['patient_total_days']}' 
                    data-province_id='{$data['province_id']}' 
                    data-city_id='{$data['city_id']}' 
                    data-area_id='{$data['area_id']}' 
                    data-refferal_id='{$data['refferal_id']}' 
                    data-panel_id='{$data['panel_id']}' 
                    data-employee_id='{$data['employee_id']}' 
                    data-p_status='$payment_status' 
                    data-patient_rate='{$data['patient_rate']}' 
                    data-staff_rate='{$data['staff_rate']}' 
                    data-service_id='{$data['service_id']}' 
                    data-recovery='{$data['recovery']}' 
                    data-changes_person='{$data['changes_person']}' 
                    data-running_bill='{$data['running_bill']}'>View</button>";
            $output .= "</td>";
            $output .= "<td class='text-center'>";
                $output .= "<button class='btn btn-primary edit-patient btn-sm' 
                    data-registration_date='{$data['registration_date']}' 
                    data-mr_no='{$data['mr_no']}' 
                    data-id='{$data['patient_id']}' 
                    data-name='{$data['patient_name']}' 
                    data-attendent_name='{$data['attendent_name']}' 
                    data-email='{$data['patient_email']}' 
                    data-contact='{$data['patient_contact']}' 
                    data-whatsapp='{$data['patient_whatsapp']}' 
                    data-address='{$data['patient_address']}' 
                    data-age='{$data['patient_age']}' 
                    data-patient_status='{$data['patient_status']}' 
                    data-gender='{$data['patient_gender']}' 
                    data-ad_date='{$data['patient_admit_date']}' 
                    data-dis_date='{$data['patient_discharge_date']}' 
                    data-total_days='{$data['patient_total_days']}' 
                    data-province_id='{$data['province_id']}' 
                    data-city_id='{$data['city_id']}' 
                    data-area_id='{$data['area_id']}' 
                    data-refferal_id='{$data['refferal_id']}' 
                    data-panel_id='{$data['panel_id']}' 
                    data-employee_id='{$data['employee_id']}' 
                    data-p_status='$data[payment_status]' 
                    data-patient_rate='{$data['patient_rate']}' 
                    data-staff_rate='{$data['staff_rate']}' 
                    data-service_id='{$data['service_id']}' 
                    data-recovery='{$data['recovery']}' 
                    data-changes_person='{$data['changes_person']}' 
                    data-running_bill='{$data['running_bill']}'
                    data-note='{$data['note']}'>Edit</button>";
            $output .= "</td>";
            $output .= "<td class='text-center'>";
            if($data['disabled_status']=="enabled"){
                $output .= "<a href='patient_disabled.php?id={$data['patient_id']}' class='btn btn-danger btn-sm'>Disabled</a>";
            }else{
                $output .= "<a href='patient_enabled.php?id={$data['patient_id']}' class='btn btn-primary btn-sm'>Enabled</a>";
            }
            $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Patient Not Found</td></tr>";
}

echo $output;
?>
