<?php
include 'connection.php';

$query = "SELECT * FROM tbl_province ORDER BY id";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($province = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td>{$province['id']}</td>";
        $output .= "<td>{$province['province']}</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-province' data-id='{$province['id']}' data-province='{$province['province']}'>Edit</button>";
        $output .= "</td>";
        $output .= "<td>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-province' data-id='{$province['id']}'>Delete</button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Province Not Found</td></tr>";
}

echo $output;
?>
