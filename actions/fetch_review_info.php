<?php

include '../settings/connection.php';
include '../settings/core.php';

//Get the POST data
$userID = $_POST['userID'];
$reviewID = $_POST['reviewID'];

// Prepare the SQL statement
$sql = "SELECT reviewText, rating FROM reviews WHERE userID = ? AND reviewID = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param('ii', $userID, $reviewID);
$stmt->execute();

$result = $stmt->get_result();
$review = $result->fetch_assoc();

$stmt->close();

echo json_encode($review);
