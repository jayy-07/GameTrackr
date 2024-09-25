
<?php
include '../settings/connection.php';
include '../settings/core.php';
$userID = $_SESSION['user_id']; 

// Get the selected avatar and bio from the form
$selectedAvatar = $_POST['selectedAvatar'];
$bio = $_POST['bio'];

// Initialize avatarID to 1 (default avatar)
$avatarID = 1;

$_SESSION['avatarID'] = $selectedAvatar;
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
}else{
    $_SESSION['avatarID'] = "https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg";
}

// Insert the avatarID into the useravatar table
$sql = "INSERT INTO useravatar (userID, avatarID) VALUES (?, ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param("ii", $userID, $avatarID);
$stmt->execute();

// Insert the bio into the bios table
$sql = "INSERT INTO bios (userID, bio) VALUES (?, ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param("is", $userID, $bio);
$stmt->execute();
$_SESSION['bio'] = $bio;

// Redirect to the dashboard
header("Location: ../views/dashboard.php");
exit();
?>
