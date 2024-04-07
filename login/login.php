<?php

session_start();

$validation_error = "";
$email_value = '';

if (isset($_SESSION['login_error'])) {
    $validation_error = $_SESSION['login_error'];
    $email_value = $_SESSION['user_value'];
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="../css/home.css" rel="stylesheet" />
</head>
<body>
    <div class="container" id="sign-in-page">
        <div
            class="navbar-brand font-weight-bold"
            style="margin-left: 28%; margin-bottom: 25px;"
            id="logo-text"
            href="dashboard.html"
            >gametrackr</div
          >
        <div class="container signin-container">
          <h4 class="mb-4">Sign In</h4>
            <form id="login-form" method="post" action="../actions/login_user_action.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required pattern="(\w+)([.](?!$|[^\w]))?" id="username" placeholder="Enter your username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name = "password" id="password" required pattern="^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$"placeholder="Enter your password">
                </div>
                <p class="mb-3" id="error-message"><?php echo $validation_error; ?></p>
                <button type="submit" class="btn" name="signin" id="signin-btn">Sign In</button>
            </form>
            <br>
            <p>New to Gametrackr? <a href="register.html">Create an account</a> </p>
        </div>
    </div>

    <!-- Include Bootstrap JS (at the end of the body) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>
</body>
</html>
