<?php
include '../settings/connection.php';
include '../settings/core.php';
$userID = $_SESSION['user_id'];

// Get the selected avatar from the AJAX request
$selectedAvatar = $_POST['selectedAvatar'];

// Initialize avatarID to 1 (default avatar)
$avatarID = 1;

// If the selected avatar is not the default, get the avatarID from the database
if ($selectedAvatar != "../images/no_profile_image.png" && $selectedAvatar != null) {
    $sql = "SELECT avatarID FROM avatars WHERE link = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $selectedAvatar);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $avatarID = $row["avatarID"];
    }
    $_SESSION['avatarID'] = $selectedAvatar;
}else{
    $_SESSION['avatarID'] = "https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg";
}

// Update the avatarID in the useravatar table
$sql = "UPDATE useravatar SET avatarID = ? WHERE userID = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("ii", $avatarID, $userID);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update avatar']);
}
?>
