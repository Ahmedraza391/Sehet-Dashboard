<?php
include("connection.php");
    $province = $_POST['province'];

    if (!empty($province)) {
        $stmt = $connection->prepare("INSERT INTO tbl_province (province) VALUES (?)");
        $stmt->bind_param("s", $province);

        if ($stmt->execute()) {
            echo "Province Inserted Successfully";
        } else {
            echo "Error in Insertation of Province: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Province name is empty";
    }

$connection->close();
?>
