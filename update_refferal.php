<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['reffral_id'];
    $name = $_POST['reffral_name'];
    $company = $_POST['reffral_company'];
    $email = $_POST['reffral_email'];
    $share = $_POST['reffral_share'];

    $update_query = "UPDATE tbl_refferals SET name = '$name',company='$company',email='$email',financial_share='$share' WHERE id = $id";
    $result = mysqli_query($connection, $update_query);

    if ($result) {
        date_default_timezone_set('Asia/Karachi');
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $insert_history = mysqli_query($connection,"INSERT INTO tbl_history (page_name,changes_person,change_type,date,time)VALUES('refferals','$_POST[edit_refferal_changes_person]','edit_refferals','$date','$time')");
        echo "Refferal Successfully Updated";
    } else {
        echo 'Failed to Update Refferal';
    }
} else {
    echo 'Invalid request';
}
?>
