<?php
include("connection.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Prepare the delete statement
    $stmt = $connection->prepare("DELETE FROM tbl_patients WHERE patient_id = ?");
    $stmt->bind_param("i", $id);
    
    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Patient Deleted Successfully";
    } else {
        echo "Error in Deleting Patient: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
} else {
    echo "No ID provided.";
}

// Close the connection
$connection->close();
?>
