<?php
include '../settings/connection.php';  

$userID = $_POST['userID'];
$gameID = $_POST['gameID'];

// Check if the game is already in the wishlist
$query = "SELECT * FROM wishlists WHERE userID = ? AND gameID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ii", $userID, $gameID);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
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
?>
