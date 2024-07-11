<?php
include("connection.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['edit_panel_id'];
    $company = $_POST['edit_panel_comapny'];
    $manager = $_POST['edit_panel_manager'];
    $email = $_POST['edit_panel_email'];
    $p_contact = $_POST['edit_panel_contact_num'];
    $manager_contact = $_POST['edit_panel_manager_contact_num'];
    $province = $_POST['edit_province'];
    $city = $_POST['edit_city'];
    $area = $_POST['edit_area'];
    $services = $_POST['edit_services'];
    $fetched_services = implode(",", $services);

    $query = "UPDATE tbl_panel SET 
    company = '$company',
    focal_person = '$manager',
    email = '$email',
    focal_person_contact = '$manager_contact',
    company_contact = '$p_contact',
    province_id = '$province',
    city_id = '$city',
    area_id = '$area',
    services = '$fetched_services' WHERE id = '$id';";

    if (mysqli_query($connection, $query)) {
        echo "Panel Updated Successfully";
    } else {
        echo "Error in Panel Updatation";
    }
}
