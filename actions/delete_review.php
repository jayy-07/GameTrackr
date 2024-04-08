<?php

include '../settings/connection.php';

// Get the POST data
$reviewID = $_POST['reviewID'];

// Prepare the SQL statement
$sql = "DELETE FROM reviews WHERE reviewID = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param('i', $reviewID);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(array('status' => 'success', 'message' => 'Review deleted successfully.'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Failed to delete review.'));
}

$stmt->close();

?>
