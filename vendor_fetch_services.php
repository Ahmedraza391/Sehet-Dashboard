<?php
include 'connection.php';

if (isset($_POST['vendor_id'])) {
    $vendor_id = $_POST['vendor_id'];
    $services = [];
    
    // Fetch sub-services
    $services_query = "SELECT id, sub_service FROM tbl_sub_services";
    $services_result = mysqli_query($connection, $services_query);

    if (!$services_result) {
        echo json_encode(['error' => "Error fetching sub-services: " . mysqli_error($connection)]);
        exit;
    }

    while ($service = mysqli_fetch_assoc($services_result)) {
        $services[$service['id']] = [
            'sub_services_id' => $service['id'],
            'sub_service' => $service['sub_service'],
            'sub_service_price' => 0,
            'selected' => false,
            'extra_services' => []
        ];
    }

    // Fetch selected sub-services
    $selected_services_query = "
        SELECT sub_service_id, sub_service_price 
        FROM tbl_vendor_services
        WHERE vendor_id = ?
        AND extra_service_id IS NULL
    ";
    $stmt = mysqli_prepare($connection, $selected_services_query);
    mysqli_stmt_bind_param($stmt, 'i', $vendor_id);
    mysqli_stmt_execute($stmt);
    $selected_services_result = mysqli_stmt_get_result($stmt);

    if (!$selected_services_result) {
        echo json_encode(['error' => "Error fetching selected sub-services: " . mysqli_error($connection)]);
        exit;
    }

    while ($selected_service = mysqli_fetch_assoc($selected_services_result)) {
        $sub_service_id = $selected_service['sub_service_id'];
        if (isset($services[$sub_service_id])) {
            $services[$sub_service_id]['sub_service_price'] = $selected_service['sub_service_price'];
            $services[$sub_service_id]['selected'] = true;
        }
    }

    // Fetch extra services
    $extra_services_query = "
        SELECT id, extra_service, sub_services_id 
        FROM tbl_extra_services
    ";
    $extra_services_result = mysqli_query($connection, $extra_services_query);

    if (!$extra_services_result) {
        echo json_encode(['error' => "Error fetching extra services: " . mysqli_error($connection)]);
        exit;
    }

    while ($extra_service = mysqli_fetch_assoc($extra_services_result)) {
        $sub_service_id = $extra_service['sub_services_id'];
        if (isset($services[$sub_service_id])) {
            $services[$sub_service_id]['extra_services'][$extra_service['id']] = [
                'extra_services_id' => $extra_service['id'],
                'extra_service' => $extra_service['extra_service'],
                'extra_service_price' => 0,
                'selected' => false
            ];
        }
    }

    // Fetch selected extra services
    $selected_extra_services_query = "
        SELECT extra_service_id, extra_service_price, sub_service_id 
        FROM tbl_vendor_services
        WHERE vendor_id = ?
        AND extra_service_id IS NOT NULL
    ";
    $stmt = mysqli_prepare($connection, $selected_extra_services_query);
    mysqli_stmt_bind_param($stmt, 'i', $vendor_id);
    mysqli_stmt_execute($stmt);
    $selected_extra_services_result = mysqli_stmt_get_result($stmt);

    if (!$selected_extra_services_result) {
        echo json_encode(['error' => "Error fetching selected extra services: " . mysqli_error($connection)]);
        exit;
    }

    while ($selected_extra_service = mysqli_fetch_assoc($selected_extra_services_result)) {
        $sub_service_id = $selected_extra_service['sub_service_id'];
        $extra_service_id = $selected_extra_service['extra_service_id'];
        if (isset($services[$sub_service_id]['extra_services'][$extra_service_id])) {
            $services[$sub_service_id]['extra_services'][$extra_service_id]['extra_service_price'] = $selected_extra_service['extra_service_price'];
            $services[$sub_service_id]['extra_services'][$extra_service_id]['selected'] = true;
        }
    }

    echo json_encode(array_values($services));
} else {
    echo json_encode([]);
}
?>
