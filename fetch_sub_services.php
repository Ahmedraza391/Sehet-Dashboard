<?php
include 'connection.php';

$query = "SELECT tbl_sub_services.*,tbl_sub_services.status as 'sub_status',tbl_sub_services.id as 'sub_id',tbl_services.*,tbl_services.id as 's_id',tbl_services.status as 'ser_status' FROM tbl_sub_services INNER JOIN tbl_services ON tbl_sub_services.services_id = tbl_services.id WHERE tbl_services.status = 'available' ORDER BY sub_id ";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($service = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td class='text-center'>{$service['sub_id']}</td>";
        $output .= "<td class='text-left'>{$service['sub_service']}</td>";
        $output .= "<td class='text-left'>Rs {$service['sub_service_price']}/-</td>";
        $output .= "<td class='text-left'>{$service['service']}</td>";
        $output .= "<td class='text-center'>";
            if($service['sub_status']=="unavailable"){
                $output .= "<a href='sub_services_available.php?id={$service['sub_id']}'  class='btn btn-primary btn-sm'>Available</a>";
            }else{  
                $output .= "<a href='sub_services_unavailable.php?id={$service['sub_id']}' class='btn btn-danger btn-sm'>Unavailable</a>";
            }
        $output .= "</td>";
        $output .= "<td class='text-center'>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-sub-service' data-id='{$service['sub_id']}' data-subservice='{$service['sub_service']}'  data-subservice_price='{$service['sub_service_price']}' data-serviceid='{$service['s_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td class='text-center'>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-sub-service' data-id='{$service['sub_id']}'>Delete</button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Services Not Found</td></tr>";
}

echo $output;
?>
