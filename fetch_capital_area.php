<?php
include 'connection.php';

$query = "SELECT tbl_area.*, tbl_area.id as 'a_id', tbl_city.*, tbl_city.id as 'c_id'
FROM tbl_area
INNER JOIN tbl_city ON tbl_area.city_id = tbl_city.id ORDER BY a_id";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($area = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$area['a_id']}</td>";
        $output .= "<td>{$area['area']}</td>";
        $output .= "<td>{$area['city']}</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-capital-area' data-id='{$area['a_id']}' data-area='{$area['area']}' data-city='{$area['c_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-capital-area' data-id='{$area['a_id']}'>Delete</button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Area Not Found</td></tr>";
}

echo $output;
?>
