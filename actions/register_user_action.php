<?php
session_start();
include '../settings/connection.php';

$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
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

    $password = $_POST['password2'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($errors)) {
        $query = "INSERT INTO users (userName, email, passwd) VALUES (?, ?, ?)";

        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $userID = mysqli_insert_id($db);
            $_SESSION['user_id'] = $userID;
            header('Location: ../login/setup.php');
            exit();
        } else {
            $errors[] = "Error: " . $stmt->error;
        }
    }

    $_SESSION['register_errors'] = $errors;
    $_SESSION['email_value'] = $email;
}
