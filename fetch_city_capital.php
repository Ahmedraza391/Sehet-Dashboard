<?php
include 'connection.php';

$query = "SELECT tbl_city_capital.*,tbl_city_capital.id as 'capital_id',tbl_city.*,tbl_city.id as 'c_id' FROM tbl_city_capital INNER JOIN tbl_city ON tbl_city_capital.city_id = tbl_city.id ORDER BY capital_id";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($city = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$city['capital_id']}</td>";
        $output .= "<td>{$city['city_capital']}</td>";
        $output .= "<td>{$city['city']}</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-city-capital' data-id='{$city['capital_id']}' data-capital='{$city['city_capital']}' data-city='{$city['c_id']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-city-capital' data-id='{$city['capital_id']}'>Delete</button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>City-Capital Not Found</td></tr>";
}

echo $output;
?>
