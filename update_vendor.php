<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vendor_id = mysqli_real_escape_string($connection, $_POST['edit_vendor_id']);
    $vendor_name = mysqli_real_escape_string($connection, $_POST['edit_vendor_name']);
    $vendor_ntn = mysqli_real_escape_string($connection, $_POST['edit_vendor_ntn']);
    $focal_person = mysqli_real_escape_string($connection, $_POST['edit_focal_person']);
    $address = mysqli_real_escape_string($connection, $_POST['edit_vendor_address']);
    $contact_num = mysqli_real_escape_string($connection, $_POST['edit_vendor_contact_num']);
    $whatsapp_num = mysqli_real_escape_string($connection, $_POST['edit_vendor_w_contact_num']);
    $province = mysqli_real_escape_string($connection, $_POST['edit_vendor_province']);
    $city = mysqli_real_escape_string($connection, $_POST['edit_vendor_city']);
    $area = mysqli_real_escape_string($connection, $_POST['edit_vendor_area']);

    // Update vendor information
    $updateVendorQuery = "UPDATE tbl_vendor SET 
                        vendor_name = '$vendor_name', 
                        vendor_ntn = '$vendor_ntn', 
                        focal_person = '$focal_person', 
                        vendor_contact = '$contact_num', 
                        vendor_whatsapp = '$whatsapp_num', 
                        vendor_address = '$address', 
                        province_id = '$province', 
                        city_id = '$city', 
                        area_id = '$area' 
                        WHERE vendor_id = $vendor_id";

    if (mysqli_query($connection, $updateVendorQuery)) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection, "INSERT INTO tbl_history (page_name, changes_person, change_type, date, time) VALUES ('vendors', '$_POST[edit_vendor_changes_person]', 'edit_vendors', '$date', '$time')");
        
        // Handle services
        $edit_services = isset($_POST['edit_vendor_services']) ? $_POST['edit_vendor_services'] : [];
        $service_prices = isset($_POST['edit_vendor_service_prices']) ? $_POST['edit_vendor_service_prices'] : [];
        $extra_services = isset($_POST['edit_vendor_extra_services']) ? $_POST['edit_vendor_extra_services'] : [];
        $extra_service_prices = isset($_POST['edit_vendor_extra_service_prices']) ? $_POST['edit_vendor_extra_service_prices'] : [];

        // First, delete all existing entries for the vendor_id to start fresh
        $deleteServicesQuery = "DELETE FROM tbl_vendor_services WHERE vendor_id = $vendor_id";
        mysqli_query($connection, $deleteServicesQuery);

        // Insert selected services and their prices
        foreach ($edit_services as $service_id) {
            $service_price = isset($service_prices[$service_id]) ? $service_prices[$service_id] : 0;
            $insertServiceQuery = "INSERT INTO tbl_vendor_services (vendor_id, sub_service_id, sub_service_price) VALUES ($vendor_id, $service_id, $service_price)";
            mysqli_query($connection, $insertServiceQuery);

            // Check for associated extra services
            if (isset($extra_services[$service_id])) {
                foreach ($extra_services[$service_id] as $extra_service_id) {
                    $extra_service_price = isset($extra_service_prices[$service_id][$extra_service_id]) ? $extra_service_prices[$service_id][$extra_service_id] : 0;
                    $insertExtraServiceQuery = "INSERT INTO tbl_vendor_services (vendor_id, sub_service_id, extra_service_id, extra_service_price) 
                                                VALUES ($vendor_id, $service_id, $extra_service_id, $extra_service_price)";
                    mysqli_query($connection, $insertExtraServiceQuery);
                }
            }
        }

        echo json_encode(array("status" => "success", "message" => "Vendor updated successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error updating vendor: " . mysqli_error($connection)));
    }

    mysqli_close($connection);
}
?>
