<?php
include '../settings/core.php';
$userID = $_SESSION['user_id'];
include '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldPassword = mysqli_real_escape_string($db, $_POST['oldPassword']);
    $newPassword = mysqli_real_escape_string($db, $_POST['newPassword']);

    // Check if the new password matches the regex
    if (!preg_match("/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/", $newPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'New password does not meet the requirements']);
        return;
    }

    // Get the current user's password from the database
    $userID = $_SESSION['user_id'];  // Replace this with the actual user ID
    $result = mysqli_query($db, "SELECT passwd FROM users WHERE userID = '$userID'");
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['passwd'];

    // Verify the old password
    if (!password_verify($oldPassword, $hashedPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Old password is incorrect']);
        return;
    }

    // Update the password
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    mysqli_query($db, "UPDATE users SET passwd = '$hashedNewPassword' WHERE userID = '$userID'");

    echo json_encode(['status' => 'success', 'message' => 'Password updated successfully!']);
}
?>
