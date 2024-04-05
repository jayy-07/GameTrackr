<?php
include '../settings/connection.php';
//include '../settings/core.php';
$userID = 1;
echo $userID;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'], $_POST['guid'])) {
    $newStatus = $_POST['status'];
    $guid = $_POST['guid'];

    // Check if the game already exists in the database
    $query = "SELECT gameID FROM games WHERE guid = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $guid);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    $stmt->close();

    if ($stmt_result->num_rows == 0) {
        // If the game does not exist, insert it into the games table
        $addGameQuery = "INSERT INTO games (guid) VALUES (?)";
        $addGameStmt = $db->prepare($addGameQuery);
        $addGameStmt->bind_param("s", $guid);
        $addGameStmt->execute();
        $addGameStmt->close();

        // Get the gameID of the newly inserted game
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $guid);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        $stmt->close();
    }

    $gameID = $stmt_result->fetch_assoc()['gameID'];

    // Start transaction
    $db->begin_transaction();

    try {
        // First, remove any existing status for this game and user
        $delete = "DELETE FROM usergames WHERE userID = ? AND gameID = ?";
        $deleteStmt = $db->prepare($delete);
        $deleteStmt->bind_param("ii", $userID, $gameID);
        $deleteStmt->execute();
        $deleteStmt->close();

        if ($db->affected_rows > 0) {
            $_POST['new'] = 0;
        } else {
            $_POST['new'] = 1;
        }
        
        

        // Then, insert the new status for this game and user
        $insert = "INSERT INTO usergames (userID, gameID, statusID) VALUES (?, ?, ?)";
        $insertStmt = $db->prepare($insert);
        $insertStmt->bind_param("iii", $userID, $gameID, $newStatus);
        $insertStmt->execute();
        $insertStmt->close();

        // Commit transaction
        $db->commit();
        echo 'Status updated successfully.';
    } catch (Exception $e) {
        $db->rollback();
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request.';
}
?>
