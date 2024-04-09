<?php

include '../settings/connection.php';
include '../settings/core.php';
// Get the POST data
$reviewID = $_POST['reviewID'];
$reviewText = $_POST['reviewText'];
$rating = $_POST['rating'];

// Prepare the SQL statement
$sql = "UPDATE reviews SET reviewText = ?, rating = ? WHERE reviewID = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param('sii', $reviewText, $rating, $reviewID);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(array('status' => 'success', 'message' => 'Review updated successfully.'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Failed to update review.'));
}

$stmt->close();

?>
