<?php
include("connection.php");

$services = [];
$extra_services = [];

// Fetch all services
$servicesQuery = "SELECT * FROM tbl_sub_services";
$servicesResult = mysqli_query($connection, $servicesQuery);
while ($service = mysqli_fetch_assoc($servicesResult)) {
    $services[] = $service;
}

// Fetch all extra services
$extraServicesQuery = "SELECT * FROM tbl_extra_services";
$extraServicesResult = mysqli_query($connection, $extraServicesQuery);
while ($extraService = mysqli_fetch_assoc($extraServicesResult)) {
    $extra_services[] = $extraService;
}

$response = [
    'services' => $services,
    'extra_services' => $extra_services
];

echo json_encode($response);
?>
