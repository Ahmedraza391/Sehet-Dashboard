<?php
include("connection.php");

// Fetch all available services from the database
$query = "SELECT * FROM tbl_sub_services WHERE status = 'available'";
$result = mysqli_query($connection, $query);

$all_services = [];
while ($row = mysqli_fetch_assoc($result)) {
    $all_services[] = $row;
}

// Get the service IDs from the POST parameter and split them into an array
$services = $_POST['services'];
$sub_services_ids = explode(",", $services);

// Match these IDs with the fetched services and mark them as selected
$output = '<div class="border p-3 rounded" id="mainservices">
            <label for="mainservices" class="form-label">Select Services</label>';

foreach ($all_services as $service) {
    $selected = in_array($service['id'], $sub_services_ids) ? 'checked' : '';
    $output .= "<div class='form-check'>";
    $output .= "<input class='form-check-input' type='checkbox' name='edit_services[]' value='{$service['id']}' id='{$service['id']}' $selected>";
    $output .= "<label class='form-check-label' for='{$service['id']}'>{$service['sub_service']}</label>";
    $output .= "</div>";
}

$output .= '</div>';
echo $output;
