<?php
include 'connection.php';

$query = "SELECT * FROM tbl_services";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($service = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
        $output .= "<td class='text-center'>{$service['id']}</td>";
        $output .= "<td class='text-left'>{$service['service']}</td>";
        $output .= "<td class='text-center'>";
            if($service['status']=="unavailable"){
                $output .= "<a href='services_available.php?id={$service['id']}'  class='btn btn-primary btn-sm'>Available</a>";
            }else{  
                $output .= "<a href='services_unavailable.php?id={$service['id']}' class='btn btn-danger btn-sm'>Unavailable</a>";
            }
        $output .= "</td>";
        
        $output .= "<td class='text-center'>";
        $output .= "<button type='button' class='btn btn-primary btn-sm edit-service' data-id='{$service['id']}' data-service='{$service['service']}'>Edit</button>";
        $output .= "</td>";
        
        $output .= "<td class='text-center'>";
        $output .= "<button type='button' class='btn btn-danger btn-sm delete-service' data-id='{$service['id']}'>Delete</button>";
        $output .= "</td>";
        
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Services Not Found</td></tr>";
}

echo $output;
?>
