<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Setup</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="../css/home.css" rel="stylesheet" />
  <style>
  </style>
</head>

<body>
  <div class="container" id="setup-page">
    <div class="navbar-brand font-weight-bold" style="margin-left: 37%; margin-bottom: 25px" id="logo-text" href="dashboard.html">
      gametrackr
    </div>

    <div class="container setup-container">
      <h4 class="mb-4">Setup</h4>
      <form id="setup-form" method="post" action="../actions/setup_user_action.php">
        <div class="mb-3">
          <label for="avatar" class="form-label">Select an Avatar</label>
          <div class="row-cols-auto" id="avatar-selection">
            <?php include "../functions/display_avatars.php"; ?>
            <img class="avatar-option mr-3 rounded-circle" id="avatar-option" src="../img/no_profile_image.png" alt="No image">
          </div>
          <input type="hidden" id="selected-avatar" name="selectedAvatar" required />
        </div>
        <div class="mb-3">
          <label for="bio" class="form-label">Bio</label>
          <textarea required class="form-control" id="bio" name="bio" maxlength="200" placeholder="Enter your bio"></textarea>
        </div>
        <div id="error-message">

        </div>
        <button type="submit" class="btn" id="signin-btn">Submit</button>
      </form>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $('.avatar-option').click(function() {
      $('.avatar-option').css('filter', 'brightness(100%)');
      $(this).css('filter', 'brightness(50%)');
      var imgSrc = $(this).attr('src');
      $('#selected-avatar').val(imgSrc);
    });

    $('#setup-form').submit(function(e) {
      if ($('#selected-avatar').val() == '') {
        e.preventDefault();
        $('#error-message').html('<p>Please select an avatar</p>');
      }
    });
  </script>

</body>

</html>