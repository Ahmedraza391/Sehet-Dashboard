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
                if($data['status']=="show"){
                    $output .= "<a href='reffral_set_hide_status.php?id=$data[id]' class='btn btn-danger btn-sm'>Hide</a>";
                }else{
                    $output .= "<a href='reffral_set_show_status.php?id=$data[id]' class='btn btn-primary btn-sm'>Show</a>";
                }
            $output .= "</td>";
            $output .= "<td class='text-center'>";
                $output .= "<button class='btn btn-primary view-panel btn-sm' data-id='{$data['id']}' data-company='{$data['company']}' data-email='{$data['email']}' data-manager='{$data['focal_person']}' data-contact='{$data['company_contact']}' data-manager_contact='{$data['focal_person_contact']}' data-province_id='{$data['province_id']}' data-city_id='{$data['city_id']}' data-area_id='{$data['area_id']}' data-status='{$data['status']}' data-services='{$data['services']}'>View</button>";
            $output .= "</td>";
            $output .= "<td class='text-center'>";
                $output .= "<button class='btn btn-primary edit-panel btn-sm' data-id='{$data['id']}'>Edit</button>";
            $output .= "</td>";
            $output .= "<td class='text-center'>";
            $output .= "<button class='btn btn-danger delete-panel btn-sm' data-id='{$data['id']}' >Delete</button>";
            $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Area Not Found</td></tr>";
}

echo $output;
?>
