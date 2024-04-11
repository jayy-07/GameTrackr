<?php
include '../settings/core.php';
include '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $userID = $_SESSION['user_id']; // Replace this with the actual user ID

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit();
    }

    $query = "SELECT * FROM users WHERE email = ? AND userID != ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $email, $userID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
    } else {
        $query = "UPDATE users SET email = ? WHERE userID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("si", $email, $userID);
        $stmt->execute();
        $_SESSION['email'] = $email;

        echo json_encode(['status' => 'success']);
    }
}
?>
