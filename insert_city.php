<?php
include("connection.php");

if (isset($_POST['cty'])) {
    $city = $_POST['cty'];

    if (!empty($city)) {
        $stmt = $connection->prepare("INSERT INTO tbl_city (city) VALUES (?)");
        $stmt->bind_param("s", $city);

        if ($stmt->execute()) {
            echo "City Inserted Successfully";
        } else {
            echo "Error in Insertation of City: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "City name is empty";
    }
} else {
    echo "City data not received";
}

$connection->close();
?>
