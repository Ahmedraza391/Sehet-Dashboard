<?php
include 'connection.php';

$panel_id = $_POST['panel_id'];

// Fetch services and extra services
$services_query = "SELECT ps.panel_id, ps.sub_services_id, ss.sub_service, ps.sub_service_price
                   FROM tbl_panel_services ps
                   LEFT JOIN tbl_sub_services ss ON ps.sub_services_id = ss.id
                   WHERE ps.panel_id = $panel_id
                   GROUP BY ps.sub_services_id";

$extra_services_query = "SELECT ps.panel_id, ps.sub_services_id, ps.extra_services_id, 
                        es.extra_service, ps.extra_service_price
                   FROM tbl_panel_services ps
                   LEFT JOIN tbl_extra_services es ON ps.extra_services_id = es.id
                   WHERE ps.panel_id = $panel_id AND ps.extra_services_id IS NOT NULL";

$fetch_services = mysqli_query($connection, $services_query);
$fetch_extra_services = mysqli_query($connection, $extra_services_query);

$services = [];
if ($fetch_services) {
    while ($service = mysqli_fetch_assoc($fetch_services)) {
        $services[] = [
            'sub_services_id' => $service['sub_services_id'],
            'sub_service' => $service['sub_service'],
            'sub_service_price' => $service['sub_service_price']
        ];
    }
}

$extra_services = [];
if ($fetch_extra_services) {
    while ($extra_service = mysqli_fetch_assoc($fetch_extra_services)) {
        $extra_services[] = [
            'sub_services_id' => $extra_service['sub_services_id'],
            'extra_service' => $extra_service['extra_service'],
            'extra_service_price' => $extra_service['extra_service_price']
        ];
    }
}

$response = [
    'services' => $services,
    'extra_services' => $extra_services
];

echo json_encode($response);
?>
