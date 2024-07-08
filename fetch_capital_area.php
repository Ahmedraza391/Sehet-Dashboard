<?php
include 'connection.php';

$query = "SELECT tbl_area.*, tbl_area.id as 'a_id', tbl_city_capital.*, tbl_city_capital.id as 'c_id'
FROM tbl_area
INNER JOIN tbl_city_capital ON tbl_area.city_capital_id = tbl_city_capital.id ORDER BY a_id";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($city = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$city['a_id']}</td>";
        $output .= "<td>{$city['area']}</td>";
        $output .= "<td>{$city['city_capital']}</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-capital-area' data-id='{$city['a_id']}' data-area='{$city['area']}' data-city_capital='{$city['city_capital_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-capital-area' data-id='{$city['a_id']}'>Delete</button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Area Not Found</td></tr>";
}

echo $output;
?>
