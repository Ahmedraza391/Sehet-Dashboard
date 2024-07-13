<?php
include 'connection.php';

$query = "SELECT * FROM tbl_panel";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td class='text-center'>{$data['id']}</td>";
        $output .= "<td class='text-left'>{$data['company']}</td>";
        $output .= "<td class='text-center'>";

        // Activate or deactivate button based on status
        if ($data['status'] == "activate") {
            $output .= "<a href='panel_set_deactivate_status.php?id={$data['id']}' class='btn btn-danger btn-sm'>Deactivate</a>";
        } else {
            $output .= "<a href='panel_set_activate_status.php?id={$data['id']}' class='btn btn-primary btn-sm'>Activate</a>";
        }

        $output .= "</td>";
        $output .= "<td class='text-center'>";

        // Fetch services and extra services
        $services_query = "SELECT ps.id AS p_s_id,
                        ss.sub_service, 
                        ss.sub_service_price AS sub_price, 
                        es.extra_service, 
                        es.extra_service_price AS extra_price
                  FROM tbl_panel_services ps
                  LEFT JOIN tbl_sub_services ss ON ps.sub_services_id = ss.id
                  LEFT JOIN tbl_extra_services es ON ps.extra_services_id = es.id
                  WHERE ps.panel_id = {$data['id']}";


        $fetch_extra_services = mysqli_query($connection, $services_query);

        if ($fetch_extra_services) {
            $services = [];
            $extra_services = [];
            $sub_services = [];
            foreach($fetch_extra_services as $service){
                if (!empty($service['sub_service'])) {
                    // Main service
                    $services[] = [
                        'id' => $service['p_s_id'],
                        'sub_service' => $service['sub_service'],
                        'sub_service_price' => $service['sub_price']
                    ];
                }
                if (!empty($service['extra_service'])) {
                    // Extra service
                    $extra_services[] = [
                        'id' => $service['p_s_id'],
                        'extra_service' => $service['extra_service'],
                        'extra_service_price' => $service['extra_price']
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
                            data-sub_services='" . htmlspecialchars(json_encode($sub_services)) . "'
                            data-services='" . htmlspecialchars(json_encode($services)) . "' 
                            data-extra_services='" . htmlspecialchars(json_encode($extra_services)) . "'>View</button>";
            $output .= "</td>";
        } else {
        }

        $output .= "<td class='text-center'>";

        // Edit button with data attributes (assuming you have an edit functionality)
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
                        data-services='{$data['services']}'>Edit</button>";

        $output .= "</td>";
        $output .= "<td class='text-center'>";

        // Delete button with data attribute (assuming you have a delete functionality)
        $output .= "<button class='btn btn-danger delete-panel btn-sm' data-id='{$data['id']}'>Delete</button>";

        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='6'>No panels found</td></tr>";
}

echo $output;
