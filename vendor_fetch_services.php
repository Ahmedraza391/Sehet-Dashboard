<?php
include 'connection.php';

if (isset($_POST['vendor_id'])) {
    $vendor_id = $_POST['vendor_id'];

    // Fetch sub-services
    $fetch_sub_services = mysqli_query($connection, "SELECT id, sub_service,sub_service_price FROM tbl_sub_services");

    // Fetch extra-services
    $fetch_extra_services = mysqli_query($connection, "SELECT id, extra_service,extra_service_price, sub_services_id FROM tbl_extra_services");

    // Fetch service details for the specific vendor
    $fetch_service_query = mysqli_query($connection, "
        SELECT tbl_vendor_services.sub_service_id, tbl_vendor_services.sub_service_price, tbl_vendor_services.extra_service_id, tbl_vendor_services.extra_service_price 
        FROM tbl_vendor_services 
        WHERE vendor_id = '$vendor_id'
    ");

    $sub_services = [];
    while ($row = mysqli_fetch_assoc($fetch_sub_services)) {
        $sub_services[$row['id']] = [
            'sub_service' => $row['sub_service'],
            'sub_service_price' => 0,
            'selected' => false,
            'extra_services' => [],
            'sub_service_original_price' => $row['sub_service_price']
        ];
    }

    // Map extra services to their corresponding sub-service
    $extra_services = [];
    while ($row = mysqli_fetch_assoc($fetch_extra_services)) {
        $extra_services[$row['sub_services_id']][$row['id']] = [
            'extra_service' => $row['extra_service'],
            'extra_service_price' => 0,
            'selected' => false,
            'extra_service_original_price' => $row['extra_service_price']
        ];
    }

    // Update sub-services and extra-services based on the vendor's selections
    while ($row = mysqli_fetch_assoc($fetch_service_query)) {
        $sub_service_id = $row['sub_service_id'];
        if (isset($sub_services[$sub_service_id])) {
            $sub_services[$sub_service_id]['sub_service_price'] = $row['sub_service_price'];
            $sub_services[$sub_service_id]['selected'] = true;
        }

        $extra_service_id = $row['extra_service_id'];
        if ($extra_service_id) {
            $sub_service_id = $row['sub_service_id'];
            if (isset($extra_services[$sub_service_id][$extra_service_id])) {
                $extra_services[$sub_service_id][$extra_service_id]['extra_service_price'] = $row['extra_service_price'];
                $extra_services[$sub_service_id][$extra_service_id]['selected'] = true;
            }
        }
    }

    // Generate HTML output
    $output = "";
    foreach ($sub_services as $sub_service_id => $sub_service) {
        $output .= '<div class="form-check">';
        $output .= '<input class="form-check-input" type="checkbox" name="edit_vendor_services[]" value="' . $sub_service_id . '" id="service_' . $sub_service_id . '" ' . ($sub_service['selected'] ? 'checked' : '') . '>';
        $output .= '<label class="form-check-label" for="service_' . $sub_service_id . '">' . $sub_service['sub_service'] . '---------' . $sub_service['sub_service_original_price'] . '</label>';
        $output .= '<input type="number" class="form-control no-spinner" name="edit_vendor_service_prices[' . $sub_service_id . ']" value="' . $sub_service['sub_service_price'] . '" placeholder="Enter Price">';
        $output .= '</div>';
    
        if (!empty($extra_services[$sub_service_id])) {
            foreach ($extra_services[$sub_service_id] as $extra_service_id => $extra_service) {
                $output .= '<div class="form-check ms-md-5">';
                $output .= '<input class="form-check-input" type="checkbox" name="edit_vendor_extra_services[' . $sub_service_id . '][]" value="' . $extra_service_id . '" id="extra_service_' . $extra_service_id . '" ' . ($extra_service['selected'] ? 'checked' : '') . '>';
                $output .= '<label class="form-check-label" for="extra_service_' . $extra_service_id . '">' . $extra_service['extra_service'] . '---------' . $extra_service['extra_service_original_price'] . '</label>';
                $output .= '<input type="number" class="form-control no-spinner" name="edit_vendor_extra_service_prices[' . $sub_service_id . '][' . $extra_service_id . ']" value="' . $extra_service['extra_service_price'] . '" placeholder="Enter Price">';
                $output .= '</div>';
            }
        }
    }
    echo $output;
} else {
    echo json_encode([]);
}
?>
