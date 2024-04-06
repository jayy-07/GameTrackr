<?php
include '../settings/connection.php';
session_start();
$gameID = $_SESSION['gameID'];
$userID = $_POST['userID'];
$guid = $_POST['guid'];


if ($gameID == 0) {
    $query = "SELECT gameID FROM games WHERE guid = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $guid);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    $stmt->close();


    // If the game does not exist, insert it into the games table
    $addGameQuery = "INSERT INTO games (guid) VALUES (?)";
    $addGameStmt = $db->prepare($addGameQuery);
    $addGameStmt->bind_param("s", $guid);
    $addGameStmt->execute();
    $gameID = mysqli_insert_id($db);
    $_SESSION['gameID'] = $gameID;
    $addGameStmt->close();
}



// Fetch the existing review from the database
$query = "SELECT ReviewText, Rating FROM reviews WHERE userID = ? AND gameID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ii', $userID, $gameID);
$stmt->execute();
$result = $stmt->get_result();
$existingReview = $result->fetch_assoc();

$stmt->close();

if (isset($_POST['rating']) || isset($_POST['reviewText'])) {
    // Use the existing review text and rating as defaults if no new value is provided
    $rating = isset($_POST['rating']) && $_POST['rating'] !== 'no-rating' ? $_POST['rating'] : null;
    if ($rating === 0) {
        $rating = null;
    }
    $reviewText = $_POST['reviewText'] ?? ($existingReview ? $existingReview['ReviewText'] : null);

    $query = "INSERT INTO reviews (userID, gameID, reviewText, rating, reviewDate)
              VALUES (?, ?, ?, ?, CURDATE())
              ON DUPLICATE KEY UPDATE reviewText = VALUES(reviewText), rating = VALUES(rating)";

    $stmt = $db->prepare($query);
    $stmt->bind_param('iisi', $userID, $gameID, $reviewText, $rating);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'Review submitted successfully.';
    } else {
        echo 'There was an error submitting your review.';
    }

    $stmt->close();
}
