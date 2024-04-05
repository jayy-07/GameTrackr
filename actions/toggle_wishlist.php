<?php
include '../settings/connection.php';

// Get the data from the AJAX request
$gameID = $_POST['gameID'];
$userID = $_POST['userID'];
$add = $_POST['add'];

if ($add) {
    // If add is true, add the game to the user's wishlist
    $query = "INSERT INTO wishlists (userID, gameID) VALUES (?, ?)";
} else {
    // If add is false, remove the game from the user's wishlist
    $query = "DELETE FROM wishlists WHERE userID = ? AND gameID = ?";
}

$stmt = $db->prepare($query);
$stmt->bind_param("ii", $userID, $gameID);
$stmt->execute();

// If the query was successful, echo 'success'
if ($stmt->affected_rows > 0) {
    echo 'success';
}

$stmt->close();
?>
