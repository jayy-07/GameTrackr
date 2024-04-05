<?php

session_start();
include '../settings/connection.php';


// Check if login button was clicked
if (isset($_POST['signin'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $_SESSION['user_value'] = "";

    $query = "SELECT * FROM users WHERE userName = ?";

    $stmt = $db->prepare($query);

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['passwd'])) {
            $_SESSION['user_id'] = $user['userID'];
            header('Location: ../views/dashboard.php');

        } else {
            $_SESSION['email_value'] = $email;
            $_SESSION['login_error'] = "Incorrect password.";
            header('Location: ../login/login.php');
            //exit();
        }
    } else {
        $_SESSION['user_value'] = $email;
        $_SESSION['login_error'] = "User not registered.";
        header('Location: ../login/login.php');
        //exit();
    }
} else {
    header('Location: ../login/login.php');
    exit();
}
