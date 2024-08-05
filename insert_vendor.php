<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $name = $_POST['vendor_name'];
    $ntn = $_POST['vendor_ntn'];
    $focal_person = $_POST['focal_person'];
    $contact = $_POST['vendor_contact_num'];
    $w_contact = $_POST['vendor_w_contact_num'];
    $address = $_POST['vendor_address'];
    $province = $_POST['vendor_province'];
    $city = $_POST['vendor_city'];
    $area = $_POST['vendor_area'];
    $service_prices = $_POST['service_prices'];
    $extra_service_prices = $_POST['extra_service_prices'];

    if (empty($_POST['services'])) {
        echo "Please select at least one service";
        exit;
    }

    $services = $_POST['services'];
    $extra_services = $_POST['extra_services'] ?? [];

    // Start transaction
    mysqli_begin_transaction($connection);

    try {
        // Insert main Vendor data
        $query = "INSERT INTO tbl_vendor (vendor_name, vendor_ntn, focal_person, vendor_contact, vendor_whatsapp, vendor_address, province_id, city_id, area_id, status, services)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'activate', ?)";
        $stmt = mysqli_prepare($connection, $query);
        $empty_string = ''; // Placeholder for the services field initially
        mysqli_stmt_bind_param($stmt, 'ssssssssss', $name, $ntn, $focal_person, $contact, $w_contact, $address, $province, $city, $area, $empty_string);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error inserting Vendor: " . mysqli_error($connection));
        }

        $vendor_id = mysqli_insert_id($connection);

        // Insert history
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $page_name = 'vendors';
        $change_type = 'add_vendors';
        $changes_person = $_POST['add_vendor_changes_person'];
        $query = "INSERT INTO tbl_history (page_name, changes_person, change_type, date, time) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'sssss', $page_name, $changes_person, $change_type, $date, $time);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error inserting history: " . mysqli_error($connection));
        }

        // Insert services and extra services
        foreach ($services as $sub_service_id) {
            $sub_service_price = $service_prices[$sub_service_id] ?? NULL;

            $query = "INSERT INTO tbl_vendor_services (vendor_id, sub_service_id, sub_service_price) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'iis', $vendor_id, $sub_service_id, $sub_service_price);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error inserting service: " . mysqli_error($connection));
            }

            if (isset($extra_services[$sub_service_id])) {
                foreach ($extra_services[$sub_service_id] as $extra_service_id) {
                    $extra_service_price = $extra_service_prices[$sub_service_id][$extra_service_id] ?? NULL;

                    $query = "INSERT INTO tbl_vendor_services (vendor_id, sub_service_id, extra_service_id, sub_service_price, extra_service_price)
                              VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, 'iiiss', $vendor_id, $sub_service_id, $extra_service_id, $sub_service_price, $extra_service_price);
                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception("Error inserting extra service: " . mysqli_error($connection));
                    }
                }
            }
        }

        // Convert services array to comma-separated string
        $fetched_services = implode(",", $services);

        // Update services field in tbl_vendor
        $query = "UPDATE tbl_vendor SET services = ? WHERE vendor_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'si', $fetched_services, $vendor_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error updating services: " . mysqli_error($connection));
        }

        // Commit transaction
        mysqli_commit($connection);
        echo "Vendor Inserted Successfully";
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($connection);
        echo "Error in Vendor Insertion: " . $e->getMessage();
    }
}
?>
