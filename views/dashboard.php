<?php
include '../actions/statistics.php';
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GameTrackr Dashboard</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="../css/home.css" rel="stylesheet" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand font-weight-bold" id="logo-text" href="dashboard.php">gametrackr</a>
        <ul class="navbar-nav w-100 d-flex align-items-center" id="navbar-right">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown" id="dropdown-menu">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                joeyskillz
              </a>
              <div class="dropdown-menu" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="dashboard.php">Dashboard</a>
                <a class="dropdown-item" href="games.php?status=1">Played</a>
                <a class="dropdown-item" href="games.php?status=2">Playing</a>
                <a class="dropdown-item" href="games.php?status=3">Backlog</a>
                <a class="dropdown-item" href="games.php?status=4">Wishlist</a>
                <a class="dropdown-item" href="friends.php">Friends</a>
                <a class="dropdown-item" href="reviews.php">Reviews</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../login/logout.php">Log Out</a>
              </div>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0 d-flex" method="post" action="../views/search.php">
            <input id="search-input" class="form-control me-2" type="search" name="query" placeholder="Search for games" aria-label="Search" />
            <button id="search-btn" class="btn" type="submit">Search</button>
          </form>

        </ul>
      </div>
    </nav>
  </header>

  <div class="container mt-4">

    <!-- Dashboard -->
    <div class="container">
      <h2>Dashboard</h2>
      <div class="row">
        <div class="col-md-3">
          <div class="card stat-card">
            <a href="games.php?status=1">
              <div class="card-body">
                <span class="stat-icon">✅</span>
                <h5 class="card-title">Played</h5>
                <p class="card-text" id="reviews-count"><?= $count_played; ?></p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card">
            <a href="games.php?status=2">
              <div class="card-body">
                <span class="stat-icon">🎮</span>
                <h5 class="card-title">Playing</h5>
                <p class="card-text" id="played-count"><?= $count_playing; ?></p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card">
            <a href="games.php?status=3">
              <div class="card-body">
                <span class="stat-icon">📅</span>
                <h5 class="card-title">Backlog</h5>
                <p class="card-text" id="backlog-count"><?= $count_backlog; ?></p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card">
            <a href="games.php?status=4">
              <div class="card-body">
                <span class="stat-icon">🌟</span>
                <h5 class="card-title">Wishlist</h5>
                <p class="card-text" id="wishlist-count"><?= $count_wishlist; ?></p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div id="results"></div>


    <div class="col-md-12 mt-5">
      <h4>Recent Games</h4>
      <div style="display: flex; justify-content: center; align-items: center; height: 50vh;" id="loading">
        <div class="spinner-border m-5" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <br />
      <div style="display: flex; justify-content: center; align-items: center; height: 50vh;" id="message-container">
      </div>
      <div class="row gx-4" id="games-container">

      </div>
    </div>
  </div>
  <footer class="page-footer navbar-expand-lg navbar-dark bg-dark">
    <p>Powered by <a href="https://www.giantbomb.com/" target="_blank">GiantBomb</a></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $("#loading").show();
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
            if (data.length == null) {
              console.log(0);
              $('#message-container').show();
              $('#message-container').html('<p>No games yet.</p>');
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
                $("#loading").hide();
                $('#games-container').append(gameCard);
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

      fetchGames(5, 1);


    });
  </script>
</body>

</html>