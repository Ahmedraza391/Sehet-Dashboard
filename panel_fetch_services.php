<?php
include 'connection.php';

if (isset($_POST['panel_id'])) {
    $panel_id = $_POST['panel_id'];

    // Fetch all services
    $services_query = "
        SELECT tbl_sub_services.id, tbl_sub_services.sub_service, tbl_sub_services.sub_service_price 
        FROM tbl_sub_services
    ";

    $services_result = mysqli_query($connection, $services_query);

    $services = [];
    while ($service = mysqli_fetch_assoc($services_result)) {
        $services[$service['id']] = [
            'sub_services_id' => $service['id'],
            'sub_service' => $service['sub_service'],
            'sub_service_price' => 0,
            'selected' => 0,
            'extra_services' => [],
            'sub_services_original_price' => $service['sub_service_price']
        ];
    }

    // Fetch selected services and their prices for the given panel
    $selected_services_query = "
        SELECT tbl_panel_services.sub_services_id, tbl_panel_services.sub_service_price 
        FROM tbl_panel_services
        WHERE tbl_panel_services.panel_id = $panel_id
        AND tbl_panel_services.extra_services_id IS NULL
    ";

    $selected_services_result = mysqli_query($connection, $selected_services_query);

    while ($selected_service = mysqli_fetch_assoc($selected_services_result)) {
        if (isset($services[$selected_service['sub_services_id']])) {
            $services[$selected_service['sub_services_id']]['sub_service_price'] = $selected_service['sub_service_price'];
            $services[$selected_service['sub_services_id']]['selected'] = 1;
        }
    }

    // Fetch extra services
    $extra_services_query = "
        SELECT tbl_extra_services.id, tbl_extra_services.extra_service, tbl_extra_services.sub_services_id, tbl_extra_services.extra_service_price
        FROM tbl_extra_services
    ";

    $extra_services_result = mysqli_query($connection, $extra_services_query);

    while ($extra_service = mysqli_fetch_assoc($extra_services_result)) {
        if (isset($services[$extra_service['sub_services_id']])) {
            $services[$extra_service['sub_services_id']]['extra_services'][$extra_service['id']] = [
                'extra_services_id' => $extra_service['id'],
                'extra_service' => $extra_service['extra_service'],
                'extra_service_price' => 0,
                'selected' => 0,
                'extra_services_original_price' => $extra_service['extra_service_price']
            ];
        }
    }

    // Fetch selected extra services and their prices for the given panel
    $selected_extra_services_query = "
        SELECT tbl_panel_services.extra_services_id, tbl_panel_services.extra_service_price, tbl_panel_services.sub_services_id 
        FROM tbl_panel_services
        WHERE tbl_panel_services.panel_id = $panel_id
        AND tbl_panel_services.extra_services_id IS NOT NULL
    ";

    $selected_extra_services_result = mysqli_query($connection, $selected_extra_services_query);

    while ($selected_extra_service = mysqli_fetch_assoc($selected_extra_services_result)) {
        $sub_services_id = $selected_extra_service['sub_services_id'];
        $extra_services_id = $selected_extra_service['extra_services_id'];
        if (isset($services[$sub_services_id]['extra_services'][$extra_services_id])) {
            $services[$sub_services_id]['extra_services'][$extra_services_id]['extra_service_price'] = $selected_extra_service['extra_service_price'];
            $services[$sub_services_id]['extra_services'][$extra_services_id]['selected'] = 1;
        }
    }

    // Output the data as JSON
    echo json_encode(array_values($services));
} else {
    echo json_encode([]);
}
?>
