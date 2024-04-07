<?php
include "../settings/connection.php";

$sql = "SELECT * FROM avatars WHERE NOT avatarID = 1";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $avatarID = $row["avatarID"];
        $avatarLink = $row["link"];

        // Display avatars in the specified format
        echo '<img class="avatar-option mr-3 rounded-circle" id="avatar-option" src="' . $avatarLink . '" alt="Avatar ' . $avatarID . '">';
    }
} else {
    echo "No avatars found.";
}

// Close the database connection
$db->close();
