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
        echo "Refferal Successfully Updated";
    } else {
        echo 'Failed to Update Refferal';
    }
} else {
    echo 'Invalid request';
}
?>
