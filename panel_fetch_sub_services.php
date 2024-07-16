<?php
include("connection.php");

// Fetch all available services from the database
$serviceQuery = "SELECT * FROM tbl_sub_services WHERE status = 'available'";
$serviceResult = mysqli_query($connection, $serviceQuery);

$all_services = [];
while ($row = mysqli_fetch_assoc($serviceResult)) {
    $all_services[] = $row;
}

// Get the panel ID from the POST parameter
$panel_id = $_POST['panel_id'];

// Fetch the selected services and extra services for the given panel ID
$selectedServicesQuery = "SELECT * FROM tbl_panel_services WHERE panel_id = $panel_id";
$selectedServicesResult = mysqli_query($connection, $selectedServicesQuery);

$selectedServices = [];
$selectedExtraServices = [];

while ($row = mysqli_fetch_assoc($selectedServicesResult)) {
    $selectedServices[] = $row['sub_services_id'];
    if (!is_null($row['extra_services_id'])) {
        $selectedExtraServices[$row['sub_services_id']][] = $row['extra_services_id'];
    }
}

// Output the main services and check if each service has extra services
$output = '<div class="border p-3 rounded" id="mainservices">
            <label for="mainservices" class="form-label">Select Services</label>';

foreach ($all_services as $service) {
    $selected = in_array($service['id'], $selectedServices) ? 'checked' : '';
    $output .= "<div class='form-check'>";
    $output .= "<input class='form-check-input' type='checkbox' name='edit_services[]' value='{$service['id']}' id='{$service['id']}' $selected>";
    $output .= "<label class='form-check-label' for='{$service['id']}'>{$service['sub_service']} (Price: {$service['sub_service_price']})</label>";

    // Check if there are extra services for the current sub-service
    $extraServiceQuery = "SELECT * FROM tbl_extra_services WHERE sub_services_id = {$service['id']}";
    $extraServiceResult = mysqli_query($connection, $extraServiceQuery);

    if (mysqli_num_rows($extraServiceResult) > 0) {
        $output .= "<div class='form-group' style='margin-left: 20px;'>";
        $output .= "<label for='extra_services_{$service['id']}'>Choose extra services:</label>";

        while ($extraServiceRow = mysqli_fetch_assoc($extraServiceResult)) {
            $extraSelected = isset($selectedExtraServices[$service['id']]) && in_array($extraServiceRow['id'], $selectedExtraServices[$service['id']]) ? 'checked' : '';
            $output .= "<div class='form-check'>";
            $output .= "<input class='form-check-input' type='checkbox' name='extra_services[{$service['id']}][]' value='{$extraServiceRow['id']}' id='extra_service_{$extraServiceRow['id']}' $extraSelected>";
            $output .= "<label class='form-check-label' for='extra_service_{$extraServiceRow['id']}'>{$extraServiceRow['extra_service']} (Price: {$extraServiceRow['extra_service_price']})</label>";
            $output .= "</div>";
        }
        $output .= "</div>";
    }

    $output .= "</div>";
}

$output .= '</div>';
echo $output;
?>
