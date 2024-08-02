<?php
session_start();
include 'connection.php';

$query = "SELECT * FROM tbl_services";
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
        $output .= "<td class='text-center'>{$service['id']}</td>";
        $output .= "<td class='text-left'>{$service['service']}</td>";
        $output .= "<td class='text-center'>";
            if($service['status']=="unavailable"){
                $output .= "<a href='services_available.php?id={$service['id']} & c_person={$changes}' class='btn btn-primary btn-sm'>Available</a>";
            }else{  
                $output .= "<a href='services_unavailable.php?id={$service['id']} & c_person={$changes}' class='btn btn-danger btn-sm'>Unavailable</a>";
            }
        $output .= "</td>";
        
        $output .= "<td class='text-center'>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-service' data-id='{$service['id']}' data-service='{$service['service']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td class='text-center'>";
            if($service['disabled_status']=="enabled"){
                $output .= "<a href='service_disabled.php?id={$service['id']} & c_person={$changes}' type='button' class='btn btn-danger btn-sm'>Disable</a>";
            }else{
                $output .= "<a href='service_enabled.php?id={$service['id']} & c_person={$changes}' type='button' class='btn btn-primary btn-sm'>Enable</a>";
            }
        $output .= "</td>";
        
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Manage Services Not Found</td></tr>";
}

echo $output;
?>
