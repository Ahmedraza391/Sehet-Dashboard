<?php
include("connection.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Prepare the delete statement
    $stmt = $connection->prepare("DELETE FROM tbl_panel WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Panel Deleted Successfully";
    } else {
        echo "Error in Deleting Panel: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
} else {
    echo "No ID provided.";
}

// Close the connection
$connection->close();
?>
