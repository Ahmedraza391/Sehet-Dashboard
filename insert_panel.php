<?php
include("connection.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company = $_POST['panel_comapny'];
    $manager = $_POST['panel_manager'];
    $email = $_POST['panel_email'];
    $p_contact = $_POST['panel_contact_num'];
    $manager_contact = $_POST['panel_manager_contact_num'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $area = $_POST['area_id'];
    $services = $_POST['services'];
    $fetched_services = implode(",", $services);

    $query = "INSERT INTO tbl_panel(company, email, focal_person, company_contact, focal_person_contact, province_id, city_id, area_id, services) 
              VALUES ('$company', '$email', '$manager', '$p_contact', '$manager_contact', '$province', '$city', '$area', '$fetched_services')";

    if (mysqli_query($connection, $query)) {
        echo "Panel Inserted Successfully";
    } else {
        echo "Error in Panel Insertion";
    }
}
?>