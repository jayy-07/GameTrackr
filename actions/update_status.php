<?php
include '../settings/connection.php';
//include '../settings/core.php';
session_start();
$userID = 1;
$gameID = $_SESSION['gameID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'], $_POST['guid'])) {
    $newStatus = $_POST['status'];
    $guid = $_POST['guid'];

    // Check if the game already exists in the database
    if ($gameID == 0) {
        $query = "SELECT gameID FROM games WHERE guid = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $guid);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        $stmt->close();
    
        $addGameQuery = "INSERT INTO games (guid) VALUES (?)";
        $addGameStmt = $db->prepare($addGameQuery);
        $addGameStmt->bind_param("s", $guid);
        $addGameStmt->execute();
        $gameID = mysqli_insert_id($db);
        $_SESSION['gameID'] = $gameID;
        $addGameStmt->close();
    }

    //$gameID = $stmt_result->fetch_assoc()['gameID'];

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
