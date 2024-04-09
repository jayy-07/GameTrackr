<?php
include '../settings/connection.php';
include '../settings/core.php';
$userID = $_POST['userID'];
$gameID = $_SESSION['gameID'];
$guid = $_POST['guid'];
$gameName = $_POST['gameName'];
$gameImage = $_POST['gameImage'];
$gamePublisher = $_POST['gamePublisher'];


if ($gameID == 0) {
    $query = "SELECT gameID FROM games WHERE guid = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $guid);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    $stmt->close();

    $addGameQuery = "INSERT INTO games (guid, name, image, publisher) VALUES (?,?,?,?)";
    $addGameStmt = $db->prepare($addGameQuery);
    $addGameStmt->bind_param("ssss", $guid, $gameName, $gameImage, $gamePublisher);
    $addGameStmt->execute();
    $gameID = mysqli_insert_id($db);
    $_SESSION['gameID'] = $gameID;
    $addGameStmt->close();
}

// Check if the game is already in the wishlist
$query = "SELECT * FROM wishlists WHERE userID = ? AND gameID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ii", $userID, $gameID);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $query = "DELETE FROM wishlists WHERE userID = ? AND gameID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $userID, $gameID);
    $stmt->execute();
    echo "removed";
} else {
    // If the game is not in the wishlist, add it
    $query = "INSERT INTO wishlists (userID, gameID) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $userID, $gameID);
    $stmt->execute();
    echo "added";
}
