<?php
include 'connection.php';

$query = "SELECT * FROM tbl_city";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($city = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$city['id']}</td>";
        $output .= "<td>{$city['city']}</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-city' data-id='{$city['id']}' data-city='{$city['city']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-city' data-id='{$city['id']}'>Delete</button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>City Not Found</td></tr>";
}

echo $output;
?>
