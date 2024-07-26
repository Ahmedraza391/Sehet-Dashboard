<?php
include("connection.php");

// SQL query to fetch employees
$sql = "SELECT * FROM tbl_users";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
            echo "<td class='text-center'>" . htmlspecialchars($row["user_id"]) . "</td>";
            echo "<td class='text-left'>" . htmlspecialchars($row["user_name"]) . "</td>";
            echo "<td class='text-left'>" . htmlspecialchars($row["user_email"]) . "</td>";
            echo "<td class='text-left'>" . htmlspecialchars($row["user_contact"]) . "</td>";
            echo "<td class='text-center'>";
                if($row["user_status"] == "deactivate"){
                    echo "<a href='activate_user.php?id=" . urlencode($row['user_id']) . "' class='btn btn-primary btn-sm'>Activate</a>";
                } else {
                    echo "<a href='deactivate_user.php?id=" . urlencode($row['user_id']) . "' class='btn btn-danger btn-sm'>Deactivate</a>";
                }
            echo "</td>";
            $pages = explode(",", $row['pages_access']);
            // View Employee
            echo "<td class='text-center'><button class='btn btn-primary btn-sm view-user' data-id='" . htmlspecialchars($row['user_id']) . "' data-name='" . htmlspecialchars($row['user_name']) . "' data-f_name='" . htmlspecialchars($row['user_father_name']) . "' data-email='" . htmlspecialchars($row['user_email']) . "' data-password='" . htmlspecialchars($row['user_password']) . "' data-contact='" . htmlspecialchars($row['user_contact']) . "' data-nic='" . htmlspecialchars($row['user_nic']) . "' data-dob='" . htmlspecialchars($row['user_dob']) . "' data-status='" . htmlspecialchars($row['user_status']) . "' data-pages='" . htmlspecialchars(json_encode($pages)) . "'>View</button></td>";
            // Edit Employee
            echo "<td class='text-center'><button class='btn btn-primary btn-sm edit-user' data-id='" . htmlspecialchars($row['user_id']) . "' data-name='" . htmlspecialchars($row['user_name']) . "' data-f_name='" . htmlspecialchars($row['user_father_name']) . "' data-email='" . htmlspecialchars($row['user_email']) . "'  data-password='" . htmlspecialchars($row['user_password']) . "' data-contact='" . htmlspecialchars($row['user_contact']) . "' data-nic='" . htmlspecialchars($row['user_nic']) . "' data-dob='" . htmlspecialchars($row['user_dob']) . "' data-status='" . htmlspecialchars($row['user_status']) . "' data-pages='" . htmlspecialchars(json_encode($pages)) . "'>Edit</button></td>";
            // Delete Employee
            echo "<td class='text-center'><button class='btn btn-danger btn-sm delete-user' data-id='" . htmlspecialchars($row['user_id']) . "'>Delete</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No Users found</td></tr>";
}

$connection->close();
?>
