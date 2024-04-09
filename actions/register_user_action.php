<?php
session_start();
include '../settings/connection.php';

$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password2'];

    // Validate username
    if (!preg_match('/^\w[\w.]{1,28}[\w]$/', $username)) {
        $errors[] = "Invalid input detected";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid input detected";
    }
    // Validate password
    if (!preg_match('/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/', $password)) {
        $errors[] = "Invalid input detected";
    }

    // Check if email already exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Email already exists.";
    }

    $query = "SELECT * FROM users WHERE userName = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Username has already been taken.";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($errors)) {
        $query = "INSERT INTO users (userName, email, passwd) VALUES (?, ?, ?)";

        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $userID = mysqli_insert_id($db);
            $_SESSION['user_id'] = $userID;
            $_SESSION['user_name'] = $username;
            $_SESSION['email'] = $email;
            exit();
        } else {
            $errors[] = "Error: " . $stmt->error;
        }
    }

    if (!empty($errors)) {
        echo implode('<br>', $errors);
    }
}
