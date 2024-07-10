<?php
include("connection.php");

$ids = $_POST['ids'];
$id_array = explode(",", $ids);

// Prepare query to fetch panels with matching service IDs
$fetch_query = "SELECT * FROM tbl_panel WHERE";
foreach ($id_array as $index => $id) {
    if ($index > 0) {
        $fetch_query .= " OR";
    }
    $fetch_query .= " FIND_IN_SET('$id', services) > 0";
}

$result = mysqli_query($connection, $fetch_query);

if (mysqli_num_rows($result) > 0) {
    $service_ids = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $service_ids = array_merge($service_ids, explode(",", $row['services']));
    }
    $service_ids = array_unique($service_ids); // Remove duplicate IDs
    $service_ids_str = implode(",", $service_ids);

    // Fetch service names from tbl_sub_services based on service IDs
    $service_query = "SELECT sub_service FROM tbl_sub_services WHERE id IN ($service_ids_str)";
    $service_result = mysqli_query($connection, $service_query);

    if (mysqli_num_rows($service_result) > 0) {
        while ($service_row = mysqli_fetch_assoc($service_result)) {
            echo "".htmlspecialchars($service_row['sub_service']) . ", ". " ";
        }
    } else {
        echo "No matching services found";
    }
} else {
    echo "Empty";
}
?>
