<?php
session_start();
include 'connection.php';

$query = "SELECT * FROM tbl_province ORDER BY id";
$result = mysqli_query($connection, $query);
$output = '';
$changes = "";
if (isset($_SESSION['admin'])) {
    $changes = "Admin";
}else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}
if (mysqli_num_rows($result) > 0) {
    while ($province = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$province['id']}</td>";
        $output .= "<td>{$province['province']}</td>";
        $output .= "<td class='text-center'>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-province' data-id='{$province['id']}' data-province='{$province['province']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td class='text-center'>";
            if($province['disabled_status']=="enabled"){
                $output .= "<a href='province_disabled.php?id={$province['id']} & c_person={$changes}' class='btn btn-danger btn-sm'>Disable</a>";
            }else{
                $output .= "<a href='province_enabled.php?id={$province['id']} & c_person={$changes}' class='btn btn-primary btn-sm'>Enable</a>";
            }
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Province Not Found</td></tr>";
}

echo $output;
?>
