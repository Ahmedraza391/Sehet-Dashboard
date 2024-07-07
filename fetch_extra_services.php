<?php
include 'connection.php';

$query = "SELECT tbl_extra_services.*,tbl_extra_services.id as 'e_s_id',tbl_sub_services.*,tbl_sub_services.id as 's_s_id' FROM tbl_extra_services INNER JOIN tbl_sub_services ON tbl_extra_services.sub_services_id = tbl_sub_services.id ORDER BY e_s_id";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($service = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$service['e_s_id']}</td>";
        $output .= "<td>{$service['extra_service']}</td>";
        $output .= "<td>{$service['sub_service']}</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-extra-service' data-id='{$service['e_s_id']}' data-extraservice='{$service['extra_service']}' data-subserviceid='{$service['s_s_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-extra-service' data-id='{$service['e_s_id']}'>Delete</button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Services Not Found</td></tr>";
}

echo $output;
?>
