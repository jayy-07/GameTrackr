<!DOCTYPE html>
<html lang="en">
<?php include '../settings/core.php'; ?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="../css/home.css" rel="stylesheet" />
  <style>
    .avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }
  </style>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand font-weight-bold" id="logo-text" href="dashboard.php">gametrackr</a>
        <ul class="navbar-nav w-100 d-flex align-items-center" id="navbar-right">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown" id="dropdown-menu">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img id="avatar" src="<?= $_SESSION['avatarID']; ?>" class="mr-3 rounded-circle d-block" alt="Profile Photo" style="width: 30px; height: 30px; margin-right: 15px;" />
                <span id=username><?= $_SESSION['user_name']; ?></span>
              </a>
              <div class="dropdown-menu" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="dashboard.php">Dashboard</a>
                <a class="dropdown-item" href="games.php?status=1">Played</a>
                <a class="dropdown-item" href="games.php?status=2">Playing</a>
                <a class="dropdown-item" href="games.php?status=3">Backlog</a>
                <a class="dropdown-item" href="games.php?status=4">Wishlist</a>
                <a class="dropdown-item" href="reviews.php">Reviews</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../login/logout.php">Log Out</a>
              </div>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0 d-flex" method="get" action="../views/search.php">
            <input id="search-input" class="form-control me-2" type="search" name="query" placeholder="Search for games" aria-label="Search" />
            <button id="search-btn" class="btn" type="submit">Search</button>
          </form>

        </ul>
      </div>
    </nav>
  </header>


  <div class="container mt-4" id="profile-page">
    <h2 style="margin-bottom: 50px;">Your Profile</h2>
    <div class="row">
      <div class="col-2 d-flex flex-column align-items-center" style="margin-right: 5%;">
        <img class="avatar" id="avatar" src="<?= $_SESSION['avatarID']; ?>" alt="Avatar" data-bs-toggle="modal" data-bs-target="#avatarModal">
        <br><br>
        <h4 id="username-text"><?= $_SESSION['user_name']; ?></h4>
      </div>

      <div class="col-8">
        <div class="username">
          <h4>Username</h4>
          <input type="text" class="form-control" id="username-input" value="<?= $_SESSION['user_name']; ?>" pattern="^\w[\w.]{1,28}[\w]$" placeholder="Username" oninvalid="setCustomValidity('Usernames can only include letters, numbers, underscores and full stops.')" oninput="setCustomValidity(''); document.getElementById('change-username-btn').disabled = !this.checkValidity() || this.value === '';">
          <br>
          <p class="mb-3" id="username-error-message"></p>
          <p class="mb-3" id="username-success-message"></p>
          <button class="btn btn-primary" id="change-username-btn" disabled>Change Username</button>
          <hr>
        </div>
        <div class="email">
          <h4>Email</h4>
          <input type="email" class="form-control" value="<?= $_SESSION['email']; ?>" id="email-input" placeholder="Email" oninput="document.getElementById('change-email-btn').disabled = !this.checkValidity() || this.value === '';">
          <br>
          <p class="mb-3" id="email-error-message"></p>
          <p class="mb-3" id="email-success-message"></p>
          <button class="btn btn-primary" id="change-email-btn" disabled>Change Email</button>
          <hr>
        </div>
        <div class="bio">
          <h4>Bio</h4>
          <textarea id="bio-input" class="form-control" placeholder="Bio" maxlength="200"><?= $_SESSION['bio']; ?></textarea>
          <br>
          <p class="mb-3" id="bio-error-message"></p>
          <p class="mb-3" id="bio-success-message"></p>
          <button class="btn btn-primary" id="change-bio-btn">Change Bio</button>
          <hr>
        </div>
        <div class="change-password">
          <h4>Change Password</h4>
          <input type="password" class="form-control" id="old-password-input" placeholder="Old Password" oninput="document.getElementById('change-password-btn').disabled = !this.checkValidity() || this.value === '';" required pattern="^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$"><br>
          <input type="password" class="form-control" id="new-password-input" placeholder="New Password" oninput="document.getElementById('change-password-btn').disabled = !this.checkValidity() || this.value === '';" required pattern="^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$"><br>
          <input type="password" class="form-control" id="confirm-password-input" placeholder="Confirm New Password" oninput="document.getElementById('change-password-btn').disabled = !this.checkValidity() || this.value === '';" required pattern="^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$"><br>
          <br>
          <p class="mb-3" id="password-error-message"></p>
          <p class="mb-3" id="password-success-message"></p>
          <button class="btn btn-primary" id="change-password-btn" disabled>Change Password</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="avatarModalLabel">Select an Avatar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <div class="modal-body">
          <?php include "../functions/display_avatars.php"; ?>
          <img class="avatar-option mr-3 rounded-circle" id="avatar-option" src="../images/no_profile_image.png" alt="No image">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save-avatar-btn" onclick="updateAvatar()">Save changes</button>

        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  var imgSrc;
  $('.avatar-option').click(function() {
    $('.avatar-option').css('filter', 'brightness(100%)');
    $(this).css('filter', 'brightness(50%)');
    imgSrc = $(this).attr('src');
    $('#selected-avatar').val(imgSrc);
  });

  function updateAvatar() {
    var selectedAvatar = imgSrc;
    console.log(selectedAvatar);
    $.ajax({
      url: '../actions/update_avatar_action.php',
      type: 'POST',
      data: {
        selectedAvatar: selectedAvatar
      },
      success: function(data) {
        // Close the modal and show a success message
        $('#avatarModal').modal('hide');
        $('#userDropdown #avatar').attr('src', selectedAvatar);
        $('.col-2 #avatar').attr('src', selectedAvatar);

      },
      error: function(jqXHR, textStatus, errorThrown) {
        // Handle any errors
        alert('An error occurred: ' + textStatus);
      }
    });
  }

  $('#change-username-btn').click(function() {
    var username = $('#username-input').val();

    $.post('../actions/update_username.php', {
      username: username
    }, function(data) {
      if (data.status === 'success') {
        $('#username-error-message').text('');
        $('#username-success-message').text("Your username has been updated");
        $('#username').text(username);
        $('#username-text').text(username);
      } else {
        $('#username-success-message').text("");
        $('#username-error-message').text(data.message);
      }
    }, 'json');
  });

  $('#change-email-btn').click(function() {
    var email = $('#email-input').val();

    $.post('../actions/update_email.php', {
      email: email
    }, function(data) {
      if (data.status === 'success') {
        $('#email-error-message').text('');
        $('#email-success-message').text("Your email has been updated");
      } else {
        $('#email-success-message').text("");
        $('#email-error-message').text(data.message);
      }
    }, 'json');
  });

  $('#change-bio-btn').click(function() {
    var bio = $('#bio-input').val();

    $.post('../actions/update_bio.php', {
      bio: bio
    }, function(data) {
      if (data.status === 'success') {
        $('#bio-error-message').text('');
        $('#bio-success-message').text(data.message);
      } else {
        $('#bio-error-message').text(data.message);
        $('#bio-success-message').text("");
      }
    }, 'json');
  });

  $('#change-password-btn').click(function() {
    var oldPassword = $('#old-password-input').val();
    var newPassword = $('#new-password-input').val();
    var confirmPassword = $('#confirm-password-input').val();

    if (newPassword !== confirmPassword) {
      $('#password-error-message').text('New password and confirm password do not match');
      return false;
    }

    $.post('../actions/update_password.php', {
      oldPassword: oldPassword,
      newPassword: newPassword
    }, function(data) {
      if (data.status === 'success') {
        $('#password-error-message').text('');
        $('#password-success-message').text("Your password has been updated");
      } else {
        $('#password-success-message').text("");
        $('#password-error-message').text(data.message);
      }
    }, 'json');
  });
</script>

</html>