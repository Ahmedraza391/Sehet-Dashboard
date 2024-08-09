<?php
session_start();
include 'connection.php';
$query = "SELECT * FROM tbl_refferals";
$result = mysqli_query($connection, $query);
$output = '';
$changes = "";
if (isset($_SESSION['admin'])) {
    $changes = "Admin";
} else if (isset($_SESSION['employee_user'])) {
    $changes = $_SESSION['employee_user']['user_name'];
}
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
            $output .= "<td class='text-center'>{$data['id']}</td>";
            $output .= "<td class='text-left'>{$data['name']}</td>";
            $output .= "<td class='text-center'>";
                if($data['status']=="activate"){
                    $output .= "<a href='refferal_set_deactivate_status.php?id=$data[id]&c_person=$changes' class='btn btn-danger btn-sm'>Deactivate</a>";
                }else{
                    $output .= "<a href='refferal_set_activate_status.php?id=$data[id]&c_person=$changes' class='btn btn-primary btn-sm'>Activate</a>";
                }
            $output .= "</td>";
            $output .= "<td class='text-center'>";
                $output .= "<button class='btn btn-primary view-refferal btn-sm' data-id='{$data['id']}' data-name='{$data['name']}' data-company='{$data['company']}' data-email='{$data['email']}' data-share='{$data['financial_share']}' data-status='{$data['status']}'>View</button>";
            $output .= "</td>";
            $output .= "<td class='text-center'>";
                $output .= "<button class='btn btn-primary edit-refferal btn-sm' data-id='{$data['id']}' data-name='{$data['name']}' data-company='{$data['company']}' data-email='{$data['email']}' data-share='{$data['financial_share']}' data-status='{$data['status']}'>Edit</button>";
            $output .= "</td>";
            $output .= "<td class='text-center'>";
            if($data['disabled_status']=="enabled"){
                $output .= "<a href='refferals_disabled.php?id={$data['id']} & c_person={$changes}' type='button' class='btn btn-danger btn-sm'>Disable</a>";
            }else{
                $output .= "<a href='refferals_enabled.php?id={$data['id']} & c_person={$changes}' type='button' class='btn btn-primary btn-sm'>Enable</a>";
            }
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Refferal Not Found</td></tr>";
}

echo $output;
?>
