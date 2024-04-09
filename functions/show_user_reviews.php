<?php

include '../settings/connection.php';
include_once '../settings/core.php';

$userID = $_SESSION['user_id'];

// Prepare the SQL statement
$sql = "SELECT reviews.reviewID, games.name, games.image, games.guid, reviews.reviewText, reviews.rating, reviews.reviewDate 
        FROM reviews 
        JOIN users ON reviews.userID = users.userID 
        JOIN games ON reviews.gameID = games.gameID 
        WHERE users.userID = ? AND (reviews.reviewText IS NOT NULL OR reviews.rating IS NOT NULL)";




// Create a prepared statement
$stmt = $db->prepare($sql);

// Bind parameters
$stmt->bind_param("i", $userID);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result->num_rows != 0) {
    // Fetch data and display it
    while ($row = $result->fetch_assoc()) {
        echo '<div class="row">';
        echo '<div class="col-2">';
        echo '<a href="game_page.php?guid=' . $row['guid'] . '"><img src="' . $row['image'] . '" class="img-fluid" style="object-fit: cover; width: 200px; height: 200px; border-top-left-radius: 5px; border-top-right-radius: 5px;" alt="Game Cover"></a>';
        echo '</div>';
        echo '<div class="col-8">';
        echo '<a href="game_page.php?guid=' . $row['guid'] . '" style="text-decoration: none; color: inherit;"><p style="font-size: 30px;"><strong>' . $row['name'] . '</strong></p></a>';
        echo '<div class="rating-group">';
        for ($i = 0; $i < $row['rating']; $i++) {
            echo '<span class="fa fa-star checked"></span>';
        }
        for ($i = $row['rating']; $i < 5; $i++) {
            echo '<span class="fa fa-star"></span>';
        }
        echo '</div>';
        echo '<div class="review">';
        echo $row['reviewText'] === null || $row['reviewText'] == '' ? '<p style="margin-top: 10px;">No review yet</p>' : '<p style="margin-top: 10px;">' . $row['reviewText'] . '</p>';
        echo '</div>';
        echo '<br>';
        echo '<div class="buttons">';
        echo '<button type="button" id="editButton" class="btn btn-primary" data-review-id=' . $row['reviewID'] . ' data-bs-toggle="modal" data-bs-target="#editReviewModal">Edit your review</button>';
        echo '<button type="button" Id="deleteButton" style="margin-left: 10px;" class="btn btn-danger" data-review-id=' . $row['reviewID'] . ' data-bs-toggle="modal" data-bs-target="#deleteReviewModal">Delete your review</button>';
        echo '</div>';
        echo '</div>';
        echo '<hr style="margin-bottom: 20px; margin-top: 30px;">';
        echo '</div>';
    }
} else {
    echo '<div style="display: flex; justify-content: center; align-items: center; height: 50vh;" id="message-container"><p>You have not made any reviews yet</p></div>';
}
