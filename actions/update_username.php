<?php
include '../settings/connection.php';
include '../settings/core.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $userID = $_SESSION['user_id'];

    // Validate username
    if (!preg_match('/^\w[\w.]{1,28}[\w]$/', $username)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input detected']);
        exit();
    }

    $query = "SELECT * FROM users WHERE userName = ? AND userID != ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $username, $userID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
    } else {
        $query = "UPDATE users SET userName = ? WHERE userID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("si", $username, $userID);
        $stmt->execute();
        $_SESSION['user_name']=$username;

        echo json_encode(['status' => 'success']);
    }
}
?>
