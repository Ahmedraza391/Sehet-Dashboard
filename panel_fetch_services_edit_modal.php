<?php
include 'connection.php';

if (isset($_POST['services'])) {
    $services = $_POST['services'];

    // SQL query to fetch services
    $serviceQuery = "SELECT * FROM tbl_sub_services WHERE services_id IN ($services)";
    $serviceResult = mysqli_query($connection, $serviceQuery);

    if ($serviceResult) {
        while ($serviceRow = mysqli_fetch_assoc($serviceResult)) {
            echo "<div class='form-check'>";
            echo "<input class='form-check-input' type='checkbox' name='services[]' value='{$serviceRow['id']}' id='{$serviceRow['id']}'>";
            echo "<label class='form-check-label' for='{$serviceRow['id']}'>{$serviceRow['sub_service']} (Price: {$serviceRow['sub_service_price']})</label>";

            // Check if there are extra services for the current sub-service
            $subServiceId = $serviceRow['id'];
            $extraServiceQuery = "SELECT * FROM tbl_extra_services WHERE sub_services_id = $subServiceId";
            $extraServiceResult = mysqli_query($connection, $extraServiceQuery);

            if ($extraServiceResult && mysqli_num_rows($extraServiceResult) > 0) {
                echo "<div class='form-group' style='margin-left: 20px;'>";
                echo "<label for='extra_services_{$subServiceId}'>Choose extra services:</label>";
                while ($extraServiceRow = mysqli_fetch_assoc($extraServiceResult)) {
                    echo "<div class='form-check'>";
                    echo "<input class='form-check-input' type='checkbox' name='extra_services[{$subServiceId}][]' value='{$extraServiceRow['id']}' id='extra_service_{$extraServiceRow['id']}'>";
                    echo "<label class='form-check-label' for='extra_service_{$extraServiceRow['id']}'>{$extraServiceRow['extra_service']} (Price: {$extraServiceRow['extra_service_price']})</label>";
                    echo "</div>";
                }
                echo "</div>";
                echo "<hr>";
            }

            echo "</div>";
        }
    } else {
        echo "Error fetching services: " . mysqli_error($connection);
    }
} else {
    echo "No services provided.";
}
?>
