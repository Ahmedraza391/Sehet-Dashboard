<?php
include 'connection.php';

if (isset($_POST['panel_id'])) {
    $panel_id = $_POST['panel_id'];
    
    // Fetch all services
    $services_query = "
        SELECT ss.id AS sub_services_id, ss.sub_service 
        FROM tbl_sub_services ss
    ";

    $services_result = mysqli_query($connection, $services_query);

    $services = [];
    while ($service = mysqli_fetch_assoc($services_result)) {
        $services[$service['sub_services_id']] = [
            'sub_services_id' => $service['sub_services_id'],
            'sub_service' => $service['sub_service'],
            'sub_service_price' => 0,
            'selected' => 0,
            'extra_services' => []
        ];
    }

    // Fetch selected services and their prices for the given panel
    $selected_services_query = "
        SELECT ps.sub_services_id, ps.sub_service_price 
        FROM tbl_panel_services ps
        WHERE ps.panel_id = $panel_id
        AND ps.extra_services_id IS NULL
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
        SELECT es.id AS extra_services_id, es.extra_service, es.sub_services_id 
        FROM tbl_extra_services es
    ";

    $extra_services_result = mysqli_query($connection, $extra_services_query);

    while ($extra_service = mysqli_fetch_assoc($extra_services_result)) {
        if (isset($services[$extra_service['sub_services_id']])) {
            $services[$extra_service['sub_services_id']]['extra_services'][$extra_service['extra_services_id']] = [
                'extra_services_id' => $extra_service['extra_services_id'],
                'extra_service' => $extra_service['extra_service'],
                'extra_service_price' => 0,
                'selected' => 0
            ];
        }
    }

    // Fetch selected extra services and their prices for the given panel
    $selected_extra_services_query = "
        SELECT ps.extra_services_id, ps.extra_service_price, ps.sub_services_id 
        FROM tbl_panel_services ps
        WHERE ps.panel_id = $panel_id
        AND ps.extra_services_id IS NOT NULL
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

    echo json_encode(array_values($services));
} else {
    echo json_encode([]);
}
?>
