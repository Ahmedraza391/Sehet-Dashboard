<?php
include("connection.php");

// SQL query to fetch employees
$sql = "SELECT * FROM tbl_employees";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
            echo "<td class='text-center'>" . $row["emp_id"] . "</td>";
            echo "<td class='text-left'>" . $row["emp_name"] . "</td>";
            echo "<td class='text-left'>" . $row["emp_email"] . "</td>";
            echo "<td class='text-left'>" . $row["emp_contact"] . "</td>";
            echo "<td class='text-center'>";
                if($row["emp_status"]=="deactivate"){
                    echo "<a href='activate_employee.php?id={$row['emp_id']}' class='btn btn-primary btn-sm'>Activate</a>";
                }else{
                    echo "<a href='deactivate_employee.php?id={$row['emp_id']}' class='btn btn-danger btn-sm'>Deactivate</a>";
                }
            echo "</td>";
            // View Employee
            echo "<td class='text-center'><button class='btn btn-primary btn-sm view-employee' data-id='{$row['emp_id']}' data-name='{$row['emp_name']}' data-f_name='{$row['emp_father_name']}' data-email='{$row['emp_email']}' data-contact='{$row['emp_contact']}' data-nic='{$row['emp_nic']}' data-dob='{$row['emp_dob']}' data-designation='{$row['emp_designation']}'  data-status='{$row['emp_status']}' >View</button></td>";
            // Edit Employee
            echo "<td class='text-center'><button class='btn btn-primary btn-sm edit-employee' data-id='{$row['emp_id']}' data-name='{$row['emp_name']}' data-f_name='{$row['emp_father_name']}' data-email='{$row['emp_email']}' data-contact='{$row['emp_contact']}' data-nic='{$row['emp_nic']}' data-dob='{$row['emp_dob']}' data-designation='{$row['emp_designation']}'  data-status='{$row['emp_status']}' '>Edit</button></td>";
            // Delete Employee
            echo "<td class='text-center'><button class='btn btn-danger btn-sm delete-employee' data-id='{$row['emp_id']}' >Delete</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7' class='text-center'>No employees found</td></tr>";
}

$connection->close();
?>