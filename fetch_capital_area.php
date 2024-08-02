<?php
session_start();
include 'connection.php';

$query = "SELECT tbl_area.*, tbl_area.id as 'a_id',tbl_area.disabled_status as 'dis_status', tbl_city.*, tbl_city.id as 'c_id'
FROM tbl_area
INNER JOIN tbl_city ON tbl_area.city_id = tbl_city.id ORDER BY a_id";
$result = mysqli_query($connection, $query);
$output = '';
$changes = "";
if (isset($_SESSION['admin'])) {
    $changes = "Admin";
}else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}
if (mysqli_num_rows($result) > 0) {
    while ($area = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$area['a_id']}</td>";
        $output .= "<td>{$area['area']}</td>";
        $output .= "<td>{$area['city']}</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-capital-area' data-id='{$area['a_id']}' data-area='{$area['area']}' data-city='{$area['c_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td class='text-center'>";
            if($area['dis_status']=="enabled"){
                $output .= "<a href='area_disabled.php?id={$area['a_id']} & c_person={$changes}' class='btn btn-danger btn-sm'>Disable</a>";
            }else{
                $output .= "<a href='area_enabled.php?id={$area['a_id']} & c_person={$changes}' class='btn btn-primary btn-sm'>Enable</a>";
            }
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Area Not Found</td></tr>";
}

echo $output;
?>
