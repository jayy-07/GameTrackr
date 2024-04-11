<?php
include '../settings/connection.php';
include '../settings/core.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bio = mysqli_real_escape_string($db, $_POST['bio']);

    $query = "UPDATE bios SET bio = ? WHERE userID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("si", $bio, $_SESSION['user_id']);
    $stmt->execute();
    $_SESSION['bio'] = $bio;

    echo json_encode(['status' => 'success', 'message' => 'Your bio has been updated']);
}else{
    echo json_encode(['status' => 'error','message' => 'Something went wrong']);
}
?>
