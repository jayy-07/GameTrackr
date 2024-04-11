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
    <div class="navbar-brand font-weight-bold" style="margin-left: 28%; margin-bottom: 25px" id="logo-text">
      gametrackr
    </div>

    <div class="container signin-container">
      <h4 class="mb-4">Register</h4>
      <form id="register-form" method="post">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" ; class="form-control" id="username" maxlength="30" required pattern="^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$" placeholder="Enter your username" oninvalid="setCustomValidity('Usernames can only include letters, numbers, underscores and full stops within.')" oninput="setCustomValidity('')" />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" maxlength="30" name="password" placeholder="Enter your password" oninvalid="setCustomValidity('Password must be a minimum of 6 characters. At least 1 uppercase letter, 1 lowercase letter, and 1 number. No spaces. ')" oninput="setCustomValidity('')" required pattern="^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$" />
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#register-form').on('submit', function(e) {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm-password").value;
        if (password != confirmPassword) {
          document.getElementById("error-message").innerHTML = "Passwords do not match";
          e.preventDefault(); // Prevent form submission
          return false;
        }

        e.preventDefault();
        $.ajax({
          url: '../actions/register_user_action.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function(data) {
            if (data) {
              $('#error-message').empty();
              $('#error-message').append(data);
            } else {
              window.location.href = '../login/setup.php';
            }
          }
        });
      });
    });
  </script>
</body>

</html>