<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="../css/home.css" rel="stylesheet" />
</head>

<body>
  <div class="container" id="register-page">
    <div class="navbar-brand font-weight-bold" style="margin-left: 28%; margin-bottom: 25px" id="logo-text" href="dashboard.html">
      gametrackr
    </div>

    <div class="container signin-container">
      <h4 class="mb-4">Register</h4>
      <form id="register-form" method="post" onsubmit="return validateForm()" action="../actions/register_user_action.php">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" ; class="form-control" id="username" maxlength="20" required pattern="(\w+)([.](?!$|[^\w]))?" placeholder="Enter your username" />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$" />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" maxlength="30" name="password" placeholder="Enter your password" required pattern="^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$" />
        </div>
        <div class="mb-3">
          <label for="confirm-password" class="form-label">Confirm Password</label>
          <input type="password" name="password2" class="form-control" id="confirm-password" placeholder="Confirm your password" />
        </div>
        <p class="mb-3" id="error-message"></p>
        <button type="submit" class="btn" id="signin-btn">Register</button>
      </form>
      <br />
      <p>Already have an account? <a href="login.php">Sign In</a></p>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>
  <script src="../js/register.js"></script>
</body>

</html>