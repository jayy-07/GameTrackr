<?php
include '../settings/connection.php';
$userID = 1; // replace this with the actual user ID

// SQL queries
$sql_played = "SELECT COUNT(*) as count FROM usergames WHERE statusID = 1 AND userID = $userID";
$sql_playing = "SELECT COUNT(*) as count FROM usergames WHERE statusID = 2 AND userID = $userID";
$sql_wishlist = "SELECT COUNT(*) as count FROM wishlists WHERE userID = $userID";
$sql_backlog = "SELECT COUNT(*) as count FROM usergames WHERE statusID = 3 AND userID = $userID";


// Execute the queries and store the results
$result_played = $db->query($sql_played);
$result_playing = $db->query($sql_playing);
$result_wishlist = $db->query($sql_wishlist);
$result_backlog = $db->query($sql_backlog); 

// Fetch the counts
$count_played = $result_played->fetch_assoc()['count'];
$count_playing = $result_playing->fetch_assoc()['count'];
$count_wishlist = $result_wishlist->fetch_assoc()['count'];
$count_backlog = $result_backlog->fetch_assoc()['count']; 

// Now you can use the variables $count_played, $count_playing, $count_wishlist, and $count_backlog
?>
