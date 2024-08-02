<?php
session_start();
include 'connection.php';

$query = "SELECT * FROM tbl_panel";
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
        $output .= "<td class='text-center'>{$data['id']}</td>";
        $output .= "<td class='text-left'>{$data['company']}</td>";
        $output .= "<td class='text-center'>";

        // Activate or deactivate button based on status
        if ($data['status'] == "activate") {
            $output .= "<a href='panel_set_deactivate_status.php?id={$data['id']} & c_person={$changes}' class='btn btn-danger btn-sm'>Deactivate</a>";
        } else {
            $output .= "<a href='panel_set_activate_status.php?id={$data['id']} & c_person={$changes}' class='btn btn-primary btn-sm'>Activate</a>";
        }

        $output .= "</td>";
        $output .= "<td class='text-center'>";

        // Fetch services and extra services
        $services_query = "SELECT ps.panel_id, ps.sub_services_id, ss.sub_service, ps.sub_service_price
                           FROM tbl_panel_services ps
                           LEFT JOIN tbl_sub_services ss ON ps.sub_services_id = ss.id
                           WHERE ps.panel_id = {$data['id']}
                           GROUP BY ps.sub_services_id";

        $extra_services_query = "SELECT ps.panel_id, ps.sub_services_id, ps.extra_services_id, 
                                es.extra_service, ps.extra_service_price
                           FROM tbl_panel_services ps
                           LEFT JOIN tbl_extra_services es ON ps.extra_services_id = es.id
                           WHERE ps.panel_id = {$data['id']} AND ps.extra_services_id IS NOT NULL";

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

        // View button with data attributes including services and extra_services
        $output .= "<button class='btn btn-primary view-panel btn-sm' 
                        data-id='{$data['id']}' 
                        data-company='{$data['company']}' 
                        data-email='{$data['email']}' 
                        data-manager='{$data['focal_person']}' 
                        data-contact='{$data['company_contact']}' 
                        data-manager_contact='{$data['focal_person_contact']}' 
                        data-province_id='{$data['province_id']}' 
                        data-city_id='{$data['city_id']}' 
                        data-area_id='{$data['area_id']}' 
                        data-status='{$data['status']}' 
                        data-services='" . htmlspecialchars(json_encode($services)) . "' 
                        data-extra_services='" . htmlspecialchars(json_encode($extra_services)) . "'>View</button>";
        $output .= "</td>";

        $output .= "<td class='text-center'>";
        $output .= "<button class='btn btn-primary edit-panel btn-sm' 
                    data-id='{$data['id']}' 
                    data-company='{$data['company']}' 
                    data-email='{$data['email']}' 
                    data-manager='{$data['focal_person']}' 
                    data-contact='{$data['company_contact']}' 
                    data-manager_contact='{$data['focal_person_contact']}' 
                    data-province_id='{$data['province_id']}' 
                    data-city_id='{$data['city_id']}' 
                    data-area_id='{$data['area_id']}' 
                    data-status='{$data['status']}'
                    data-services='" . htmlspecialchars(json_encode($services)) . "' 
                    data-extra_services='" . htmlspecialchars(json_encode($extra_services)) . "'>Edit</button>";
        $output .= "</td>";

        $output .= "<td class='text-center'>";
            if($data['disabled_status']=="enabled"){
                $output .= "<a href='panel_disabled.php?id={$data['id']} & c_person={$changes}' type='button' class='btn btn-danger btn-sm'>Disable</a>";
            }else{
                $output .= "<a href='panel_enabled.php?id={$data['id']} & c_person={$changes}' type='button' class='btn btn-primary btn-sm'>Enable</a>";
            }
    $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='6'>No panels found</td></tr>";
}

echo $output;
?>
