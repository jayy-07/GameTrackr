<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="../css/home.css" rel="stylesheet" />
</head>

<body>
    <div class="container" id="sign-in-page">
        <div class="navbar-brand font-weight-bold" style="margin-left: 28%; margin-bottom: 25px;" id="logo-text">gametrackr</div>
        <div class="container signin-container">
            <h4 class="mb-4">Sign In</h4>
            <form id="login-form" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required pattern="^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$" maxlength="30" minlength="3" id="username" placeholder="Enter your username" oninvalid="setCustomValidity('Usernames can only include letters, numbers, underscores and full stops.')" oninput="setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required pattern="^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$" oninvalid="setCustomValidity('Password must be a minimum of 6 characters. At least 1 uppercase letter, 1 lowercase letter, and 1 number. No spaces. ')" oninput="setCustomValidity('')" placeholder="Enter your password">
                </div>
                <p class="mb-3" id="error-message"></p>
                <button type="submit" class="btn" name="signin" id="signin-btn">Sign In</button>
            </form>
            <br>
            <p>New to Gametrackr? <a href="register.php">Create an account</a> </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '../actions/login_user_action.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data) {
                            $('#error-message').html(data);
                        } else {
                            window.location.href = '../views/dashboard.php';
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>