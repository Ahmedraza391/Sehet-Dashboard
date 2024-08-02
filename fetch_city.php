<?php
session_start();
include 'connection.php';

$query = "SELECT tbl_city.*,tbl_city.id as 'city_id',tbl_city.disabled_status as 'dis_status',tbl_province.*,tbl_province.id as 'p_id' FROM tbl_city INNER JOIN tbl_province ON tbl_city.province_id = tbl_province.id ORDER BY city_id";
$result = mysqli_query($connection, $query);
$output = '';
$changes = "";
if (isset($_SESSION['admin'])) {
    $changes = "Admin";
}else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}
if (mysqli_num_rows($result) > 0) {
    while ($city = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$city['city_id']}</td>";
        $output .= "<td>{$city['city']}</td>";
        $output .= "<td>{$city['province']}</td>";
        $output .= "<td class='text-center'>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-city' data-id='{$city['city_id']}' data-city='{$city['city']}' data-province='{$city['p_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td class='text-center'>";
            if($city['dis_status']=="enabled"){
                $output .= "<a href='city_disabled.php?id={$city['city_id']} & c_person={$changes}' class='btn btn-danger btn-sm'>Disable</a>";
            }else{
                $output .= "<a href='city_enabled.php?id={$city['city_id']} & c_person={$changes}' class='btn btn-primary btn-sm'>Enable</a>";
            }
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>City Not Found</td></tr>";
}

echo $output;
?>
