<?php
session_start();
include 'connection.php';

$query = "SELECT * FROM tbl_vendor";
$result = mysqli_query($connection, $query);
$output = '';
$changes = "";

if (isset($_SESSION['admin'])) {
    $changes = "Admin";
} else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}

if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td class='text-center'>{$data['vendor_id']}</td>";
        $output .= "<td class='text-left'>{$data['vendor_name']}</td>";
        $output .= "<td class='text-left'>{$data['vendor_ntn']}</td>";
        $output .= "<td class='text-center'>";

        // Activate or deactivate button based on status
        if ($data['status'] == "activate") {
            $output .= "<a href='vendor_set_deactivate_status.php?id={$data['vendor_id']}&c_person={$changes}' class='btn btn-danger btn-sm'>Deactivate</a>";
        } else {
            $output .= "<a href='vendor_set_activate_status.php?id={$data['vendor_id']}&c_person={$changes}' class='btn btn-primary btn-sm'>Activate</a>";
        }

        $output .= "</td>";
        $output .= "<td class='text-center'>";

        // Fetch services
        $services_query = "SELECT ps.sub_service_id, ss.sub_service, ps.sub_service_price
                           FROM tbl_vendor_services ps
                           LEFT JOIN tbl_sub_services ss ON ps.sub_service_id = ss.id
                           WHERE ps.vendor_id = {$data['vendor_id']}
                           GROUP BY ps.sub_service_id";

        // Fetch extra services
        $extra_services_query = "SELECT ps.sub_service_id, es.extra_service, ps.extra_service_price
                                 FROM tbl_vendor_services ps
                                 LEFT JOIN tbl_extra_services es ON ps.extra_service_id = es.id
                                 WHERE ps.vendor_id = {$data['vendor_id']} AND ps.extra_service_id IS NOT NULL";

        $fetch_services = mysqli_query($connection, $services_query);
        $fetch_extra_services = mysqli_query($connection, $extra_services_query);

        $services = [];
        $extra_services = [];

        if ($fetch_services) {
            while ($service = mysqli_fetch_assoc($fetch_services)) {
                $services[$service['sub_service_id']] = [
                    'sub_service' => $service['sub_service'],
                    'sub_service_price' => $service['sub_service_price'],
                    'extra_services' => []
                ];
            }
        }

        if ($fetch_extra_services) {
            while ($extra_service = mysqli_fetch_assoc($fetch_extra_services)) {
                $services[$extra_service['sub_service_id']]['extra_services'][] = [
                    'extra_service' => $extra_service['extra_service'],
                    'extra_service_price' => $extra_service['extra_service_price']
                ];
            }
        }

        // View button with data attributes including services and extra_services
        $output .= "<button class='btn btn-primary view-vendor btn-sm' 
                    data-vendor_id='{$data['vendor_id']}' 
                    data-vendor_name='{$data['vendor_name']}' 
                    data-vendor_ntn='{$data['vendor_ntn']}' 
                    data-vendor_contact='{$data['vendor_contact']}' 
                    data-vendor_w_contact='{$data['vendor_whatsapp']}' 
                    data-vendor_address='{$data['vendor_address']}' 
                    data-focal_person='{$data['focal_person']}' 
                    data-province_id='{$data['province_id']}' 
                    data-city_id='{$data['city_id']}' 
                    data-area_id='{$data['area_id']}' 
                    data-vendor_status='{$data['status']}' 
                    data-services='" . htmlspecialchars(json_encode($services)) . "' 
                    data-extra_services='" . htmlspecialchars(json_encode($extra_services)) . "'>View</button>";

        $output .= "</td>";

        $output .= "<td class='text-center'>";
        $output .= "<button class='btn btn-primary edit-vendor btn-sm' 
                    data-vendor_id='{$data['vendor_id']}' 
                    data-vendor_name='{$data['vendor_name']}' 
                    data-vendor_ntn='{$data['vendor_ntn']}' 
                    data-vendor_contact='{$data['vendor_contact']}' 
                    data-vendor_w_contact='{$data['vendor_whatsapp']}' 
                    data-vendor_address='{$data['vendor_address']}' 
                    data-focal_person='{$data['focal_person']}' 
                    data-province_id='{$data['province_id']}' 
                    data-city_id='{$data['city_id']}' 
                    data-area_id='{$data['area_id']}' 
                    data-vendor_status='{$data['status']}'
                    data-services='" . htmlspecialchars(json_encode($services)) . "' 
                    data-extra_services='" . htmlspecialchars(json_encode($extra_services)) . "'>Edit</button>";
        $output .= "</td>";

        $output .= "<td class='text-center'>";
        if ($data['disabled_status'] == "enabled") {
            $output .= "<a href='vendor_disabled.php?id={$data['vendor_id']}&c_person={$changes}' type='button' class='btn btn-danger btn-sm'>Disable</a>";
        } else {
            $output .= "<a href='vendor_enabled.php?id={$data['vendor_id']}&c_person={$changes}' type='button' class='btn btn-primary btn-sm'>Enable</a>";
        }
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='6'>No vendors found</td></tr>";
}

echo $output;
?>
