<?php
include '../settings/connection.php';

$gameId = $_POST['gameID'];
$userId = $_POST['userID'];

// Fetch the existing review from the database
$query = "SELECT ReviewText, Rating FROM reviews WHERE userID = ? AND gameID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ii', $userId, $gameId);
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
    $stmt->bind_param('iisi', $userId, $gameId, $reviewText, $rating);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'Review submitted successfully.';
    } else {
        echo 'There was an error submitting your review.';
    }

    $stmt->close();
}
