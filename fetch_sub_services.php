<?php
include 'connection.php';

$query = "SELECT tbl_sub_services.*,tbl_sub_services.id as 'sub_id',tbl_services.*,tbl_services.id as 's_id' FROM tbl_sub_services INNER JOIN tbl_services ON tbl_sub_services.services_id = tbl_services.id ORDER BY sub_id";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($service = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$service['sub_id']}</td>";
        $output .= "<td>{$service['sub_service']}</td>";
        $output .= "<td>{$service['service']}</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-sub-service' data-id='{$service['sub_id']}' data-subservice='{$service['sub_service']}' data-serviceid='{$service['s_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-service' data-id='{$service['id']}'>Delete</button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Services Not Found</td></tr>";
}

echo $output;
?>
