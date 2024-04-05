<?php
    include '../settings/connection.php';

    // Get the gameID and userID from the AJAX request
    $gameID = $_POST['gameID'];
    $userID = $_POST['userID'];

    // Prepare the SQL statement
    $sql = "DELETE FROM usergames WHERE gameID = ? AND userID = ?";

    // Create a prepared statement
    $stmt = $db->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ii", $gameID, $userID);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $db->close();
?>
