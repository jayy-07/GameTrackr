<!DOCTYPE html>
<html lang="en">
<?php include '../settings/core.php'; ?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Games</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="../css/home.css" rel="stylesheet" />
  <style>
    ::-webkit-scrollbar {
      width: 0px !important;
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
                <img src="<?= $_SESSION['avatarID']; ?>" class="mr-3 rounded-circle d-block" alt="Profile Photo" style="width: 30px; height: 30px; margin-right: 15px;" />
                <?= $_SESSION['user_name']; ?>
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

  <div style="font-family: Bahnschrift;" class="container mt-4">
    <!-- Game Categories -->
    <h2>Your Games</h2>
    <br>
    <div class="mb-4">
      <button class="btn game-button active" id="playedButton" data-status-id="1">
        Played
      </button>
      <button class="btn game-button" id="playingButton" data-status-id="2">Playing</button>
      <button class="btn game-button" id="backlogButton" data-status-id="3">Backlog</button>
      <button class="btn game-button" id="wishlistButton" data-status-id="4">Wishlist</button>
    </div>

    <!-- Game Cards -->
    <div id="game-number">
    </div>
    <div style="display: flex; justify-content: center; align-items: center; height: 50vh;" id="loading">
      <div class="spinner-border m-5" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div style="display: flex; justify-content: center; align-items: center; height: 50vh;" id="message-container">

    </div>

    <div class="row" id='games-container'>

    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    $("#loading").hide();
    $(document).ready(function() {
      function fetchGames(statusID, userID) {
        $('#games-container').empty();
        $.ajax({
          url: '../actions/fetch_games.php',
          method: 'POST',
          dataType: 'json',
          data: {
            statusID: statusID,
            userID: userID
          },
          success: function(data) {
            //console.log(data);
            if (data.length == 0) {
              //alert('Error retrieving games');
              $('#message-container').show();
              $('#message-container').html('<p>No games yet.</p>');
              $('#game-number').hide();
            } else {
              // Loop through each game
              $('#game-number').html('<p>' + data.length + (data.length === 1 ? ' game' : ' games') + '</p>');
              $('#message-container').hide();
              $('#game-number').show();

              //console.log(data);
              $.each(data, function(i, game) {
                $("#loading").show();
                var gameCard = '<div class="col-md-3" style="margin-left: 0px">' +
                  '<div class="card game-card">' +
                  '<a href="game_page.php?guid=' + game.guid + '">' +
                  '<img src="' + game.image + '" alt="' + game.name + '" style="object-fit: cover; width: 199px; height: 270px; border-top-left-radius: 5px; border-top-right-radius: 5px;"/>' +
                  '<div class="card-body">' +
                  '<h5 class="card-title">' + game.name + '</h5>' +
                  '<p class="card-text" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; font-size: 13px;">' + game.publisher + '</p>' +
                  '</div>' +
                  '</a>' +
                  '</div>' +
                  '</div>';


                // Append the new game card to the games container
                $('#games-container').append(gameCard);
                $("#loading").hide();
              });
            }
          },
          error: function() {
            //alert('Error retrieving games');
            $('#message-container').show();
            $('#message-container').html('<p>No games yet.</p>');
            $('#game-number').hide();
          }
        });
      }


      $('.game-button').click(function() {
        $('.game-button').removeClass('active');
        var statusID = $(this).data('status-id');
        var userID = <?= $_SESSION['user_id']; ?>
        //console.log(statusID);
        $(this).addClass('active');
        fetchGames(statusID, userID);
      });

      // Fetch games of status 1 when the page loads
      fetchGames(<?= isset($_GET['status']) ? $_GET['status'] : 1 ?>, <?= $_SESSION['user_id'] ?>);

      // Remove 'active' class from all buttons
      $('.game-button').removeClass('active');

      // Add 'active' class to the button with the matching 'status-id'
      $('.game-button[data-status-id="' + <?= isset($_GET['status']) ? $_GET['status'] : 1 ?> + '"]').addClass('active');
    });
  </script>
</body>

</html>