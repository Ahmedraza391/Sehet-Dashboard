<?php
include 'connection.php';

$query = "SELECT * FROM tbl_reffrals";
$result = mysqli_query($connection, $query);
$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $output .= "<tr>";
            $output .= "<td class='text-center'>{$data['id']}</td>";
            $output .= "<td class='text-left'>{$data['name']}</td>";
            $output .= "<td class='text-center'>";
                if($data['status']=="show"){
                    $output .= "<a href='reffral_set_hide_status.php?id=$data[id]' class='btn btn-danger btn-sm'>Hide</a>";
                }else{
                    $output .= "<a href='reffral_set_show_status.php?id=$data[id]' class='btn btn-primary btn-sm'>Show</a>";
                }
            $output .= "</td>";
            $output .= "<td class='text-center'>";
                $output .= "<button class='btn btn-primary view-reffrel btn-sm' data-id='{$data['id']}' data-name='{$data['name']}' data-company='{$data['company']}' data-email='{$data['email']}' data-share='{$data['financial_share']}' data-status='{$data['status']}'>View</button>";
            $output .= "</td>";
            $output .= "<td class='text-center'>";
                $output .= "<button class='btn btn-primary edit-reffral btn-sm' data-id='{$data['id']}' data-name='{$data['name']}' data-company='{$data['company']}' data-email='{$data['email']}' data-share='{$data['financial_share']}' data-status='{$data['status']}'>Edit</button>";
            $output .= "</td>";
            $output .= "<td class='text-center'>";
            $output .= "<button class='btn btn-danger delete-reffral btn-sm' data-id='{$data['id']}' >Delete</button>";
            $output .= "</td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='4'>Area Not Found</td></tr>";
}

echo $output;
?>
