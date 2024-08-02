<?php
session_start();
include 'connection.php';

$query = "SELECT tbl_extra_services.*,tbl_extra_services.id as 'e_s_id',tbl_extra_services.status as 'extra_status',tbl_extra_services.disabled_status as 'dis_status',tbl_sub_services.*,tbl_sub_services.id as 's_s_id' FROM tbl_extra_services INNER JOIN tbl_sub_services ON tbl_extra_services.sub_services_id = tbl_sub_services.id ORDER BY e_s_id";
$result = mysqli_query($connection, $query);
$output = '';
$changes = "";
if (isset($_SESSION['admin'])) {
    $changes = "Admin";
}else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}
if (mysqli_num_rows($result) > 0) {
    while ($service = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td class='text-center'>{$service['e_s_id']}</td>";
        $output .= "<td class='text-left'>{$service['extra_service']}</td>";
        $output .= "<td class='text-left'>Rs {$service['extra_service_price']}/-</td>";
        $output .= "<td class='text-left'>{$service['sub_service']}</td>";
        $output .= "<td class='text-center'>";
            if($service['extra_status']=="unavailable"){
                $output .= "<a href='extra_services_available.php?id={$service['e_s_id']} & c_person={$changes}'  class='btn btn-primary btn-sm'>Available</a>";
            }else{  
                $output .= "<a href='extra_services_unavailable.php?id={$service['e_s_id']} & c_person={$changes}' class='btn btn-danger btn-sm'>Unavailable</a>";
            }
        $output .= "</td>";
        $output .= "<td class='text-center'>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-extra-service' data-id='{$service['e_s_id']}' data-extraservice='{$service['extra_service']}'  data-extraservice_price='{$service['extra_service_price']}' data-subserviceid='{$service['s_s_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td class='text-center'>";
            if($service['dis_status']=="enabled"){
                $output .= "<a href='extra_service_disabled.php?id={$service['e_s_id']} & c_person={$changes}' class='btn btn-danger btn-sm'>Disable</a>";
            }else{
                $output .= "<a href='extra_service_enabled.php?id={$service['e_s_id']} & c_person={$changes}' class='btn btn-primary btn-sm'>Enable</a>";
            }
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Service Sub Head Not Found</td></tr>";
}

echo $output;
?>
