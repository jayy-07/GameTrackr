<?php
session_start();
include '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Validate username
    if (!preg_match('/^\w[\w.]{1,28}[\w]$/', $username)) {
        echo "Invalid input detected";
        exit();
    }

    $query = "SELECT * FROM users WHERE userName = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['passwd'])) {
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['user_name'] = $user['userName'];

            // Get avatarID from useravatar table
            $query = "SELECT avatarID FROM useravatar WHERE userID = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $user['userID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $userAvatar = $result->fetch_assoc();

            // Get avatar link from avatars table
            $query = "SELECT link FROM avatars WHERE avatarID = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $userAvatar['avatarID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $avatar = $result->fetch_assoc();

            $_SESSION['avatarID'] = $avatar['link'];

            $sql = "SELECT bio FROM bios WHERE userID = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i",  $user['userID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $bio = $result->fetch_assoc();
            $_SESSION['bio'] = $bio['bio'];

            $sql = "SELECT email FROM users WHERE userID = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i",  $user['userID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $email = $result->fetch_assoc();
            $_SESSION['email'] = $email['email'];



            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Username does not exist";
    }
}
