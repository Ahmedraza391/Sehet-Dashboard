<?php
include("connection.php");
$company = $_POST['panel_comapny'];
$manager = $_POST['panel_manager'];
$email = $_POST['panel_email'];
$p_contact = $_POST['panel_contact_num'];
$manager_contact = $_POST['panel_manager_contact_num'];
$province = $_POST['province'];
$city = $_POST['city'];
$area = $_POST['area_id'];
$query = "INSERT INTO tbl_panel(company,email,focal_person,company_contact,focal_person_contact,province_id,city_id,area_id)VALUES('$company','$email','$manager','$p_contact','$manager_contact','$province','$city','$area')";
if(mysqli_query($connection,$query)){
    echo "Panel Inserted Successfully";
}else{
    echo  "Error in Panel Insertation";
}
?>