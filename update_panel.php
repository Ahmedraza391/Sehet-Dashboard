<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch data from POST
    $panel_id = $_POST['edit_panel_id'];
    $company = $_POST['edit_panel_company'];
    $manager = $_POST['edit_panel_manager'];
    $email = $_POST['edit_panel_email'];
    $contact_num = $_POST['edit_panel_contact_num'];
    $manager_contact_num = $_POST['edit_panel_manager_contact_num'];
    $province = $_POST['edit_panel_province'];
    $city = $_POST['edit_panel_city'];
    $area = $_POST['edit_panel_area'];

    // Update panel information
    $updatePanelQuery = "UPDATE tbl_panel SET 
                        company = '$company', 
                        focal_person = '$manager', 
                        email = '$email', 
                        company_contact = '$contact_num', 
                        focal_person_contact = '$manager_contact_num', 
                        province_id = '$province', 
                        city_id = '$city', 
                        area_id = '$area' 
                        WHERE id = $panel_id";

    if (mysqli_query($connection, $updatePanelQuery)) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('panels','$_POST[edit_panel_changes_person]','edit_panels','$date','$time')");
        // Update selected services and extra services
        $edit_services = isset($_POST['edit_panel_services']) ? $_POST['edit_panel_services'] : [];
        $service_prices = isset($_POST['edit_panel_service_prices']) ? $_POST['edit_panel_service_prices'] : [];
        $extra_services = isset($_POST['edit_panel_extra_services']) ? $_POST['edit_panel_extra_services'] : [];
        $extra_service_prices = isset($_POST['edit_panel_extra_service_prices']) ? $_POST['edit_panel_extra_service_prices'] : [];

        // First, delete all existing entries for the panel_id to start fresh
        $deleteServicesQuery = "DELETE FROM tbl_panel_services WHERE panel_id = $panel_id";
        mysqli_query($connection, $deleteServicesQuery);

        // Insert selected services and their prices
        foreach ($edit_services as $service_id) {
            $service_price = isset($service_prices[$service_id]) ? $service_prices[$service_id] : 0;
            $insertServiceQuery = "INSERT INTO tbl_panel_services (panel_id, sub_services_id, sub_service_price) VALUES ($panel_id, $service_id, $service_price)";
            mysqli_query($connection, $insertServiceQuery);

            // Check for associated extra services
            if (isset($extra_services[$service_id])) {
                foreach ($extra_services[$service_id] as $extra_service_id) {
                    $extra_service_price = isset($extra_service_prices[$service_id][$extra_service_id]) ? $extra_service_prices[$service_id][$extra_service_id] : 0;
                    $insertExtraServiceQuery = "INSERT INTO tbl_panel_services (panel_id, sub_services_id, extra_services_id, extra_service_price) 
                                                VALUES ($panel_id, $service_id, $extra_service_id, $extra_service_price)";
                    mysqli_query($connection, $insertExtraServiceQuery);
                }
            }
        }

        echo "Panel Updated Successfully";
    } else {
        echo "Error updating panel: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>
