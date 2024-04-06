<?php
include '../settings/connection.php';

$statusID = $_POST['statusID'];
$userID = $_POST['userID'];


if ($statusID == 4) {
    $sql = "SELECT g.gameID, g.guid 
        FROM games g
        INNER JOIN wishlists w ON g.gameID = w.gameID
        WHERE w.userID = ?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();

    $result = $stmt->get_result();
    //print_r($result);

    $games = array();

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $games[] = array(
                'gameID' => $row["gameID"],
                'guid' => $row["guid"]
            );
        }
    } else {
        echo "0 results";
    }

    // Close connection
    $db->close();

    // Return game data as JSON
    header('Content-Type: application/json');
    echo json_encode($games);
} else if ($statusID == 5) {
    $sql_recent_games = "SELECT ug.gameID, g.guid 
                         FROM usergames ug
                         INNER JOIN games g ON ug.gameID = g.gameID
                         WHERE ug.userID = ? 
                         ORDER BY ug.lastUpdated DESC LIMIT 8";
    $stmt = $db->prepare($sql_recent_games);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result_recent_games = $stmt->get_result();
    $games = array();
    if ($result_recent_games->num_rows > 0) {
        while ($row = $result_recent_games->fetch_assoc()) {
            $games[] = array(
                'gameID' => $row["gameID"],
                'guid' => $row["guid"]
            );
        }
    } else {
        echo "0 results";
    }
    // Close connection
    $db->close();
    // Return game data as JSON
    header('Content-Type: application/json');
    echo json_encode($games);
} else {
    $sql = "SELECT g.gameID, g.guid 
        FROM games g
        INNER JOIN usergames ug ON g.gameID = ug.gameID
        WHERE ug.userID = ? AND ug.statusID = ?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $userID, $statusID);
    $stmt->execute();

    $result = $stmt->get_result();

    $games = array();

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $games[] = array(
                'gameID' => $row["gameID"],
                'guid' => $row["guid"]
            );
        }
    } else {
        echo "0 results";
    }

    // Close connection
    $db->close();

    // Return game data as JSON
    header('Content-Type: application/json');
    echo json_encode($games);
}
