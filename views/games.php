<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Game Collection</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link href="../css/home.css" rel="stylesheet" />
  <!-- Include custom CSS for styling -->
  <style>
    /* Style for game cards */
    .game-card {
      width: 100%;
      max-width: 200px;
      margin-bottom: 20px;
    }

    /* Placeholder for game cover image */
    .game-cover {
      width: 100%;
      height: auto;
      object-fit: cover;
    }

    .game-button {
      border: 2px solid transparent;
      padding: 8px 15px;
      margin-right: 10px;
      font-weight: bold;
      transition: background-color 0.3s, border-color 0.3s;
    }

    .game-button.active {
      background-color: #ff0000;
      /* Red color (you can adjust this) */
      border-color: #ff0000;
      color: white;
    }

    .game-button:hover {
      background-color: #ff0000;
      border-color: #ff0000;
      color: white;
    }

    .mb-4 {
      display: flex;
      justify-content: center;
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
                <a class="dropdown-item" href="#">Reviews</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Log Out</a>
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
      <div class="spinner-border m-5" role="status" >
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
        $.ajax({
          url: '../actions/fetch_games.php',
          method: 'POST',
          dataType: 'json',
          data: {
            statusID: statusID,
            userID: userID
          },
          success: function(data) {
            $('#games-container').empty(); // Clear the games container

            if (data.length == 0) {
              $('#games-container').empty();
              $('#message-container').html('<p>No games yet.</p>'); // Display message if no games
            } else {
              // Loop through each game
              $('#game-number').html('<p>' + data.length + (data.length === 1 ? ' game' : ' games') + '</p>');
              $.each(data, function(i, game) {
                $("#loading").show();
                // Fetch game details from the Giant Bomb API
                var url = 'https://www.giantbomb.com/api/game/' + game.guid + '/?api_key=5743a53a52963939cd8a825b048a39af6bd172a0&format=jsonp&json_callback=?';
                $.ajax({
                  url: url,
                  method: 'GET',
                  dataType: 'jsonp',
                  success: function(apiData) {
                    // Create a new game card
                    var gameCard = '<div class="col-md-3" style="margin-left: 0px">' +
                      '<div class="card game-card">' +
                      '<a href="game_page.php?guid=' + game.guid + '">' +
                      '<img src="' + apiData.results.image.original_url + '" alt="' + apiData.results.name + '" style="object-fit: cover; width: 199px; height: 270px; border-top-left-radius: 5px; border-top-right-radius: 5px;"/>' +
                      '<div class="card-body">' +
                      '<h5 class="card-title">' + apiData.results.name + '</h5>' +
                      '<p class="card-text" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; font-size: 13px;">' + apiData.results.publishers[0].name + '</p>' +
                      '</div>' +
                      '</a>' +
                      '</div>' +
                      '</div>';

                    // Append the new game card to the games container
                    $('#message-container').hide();
                    $("#loading").hide();
                    $('#game-number').show();
                    $('#games-container').append(gameCard);
                  },
                  error: function() {
                    //alert('Error retrieving game data');
                    $('#message-container').html('<p>No games yet.</p>');
                    $('#game-number').hide();

                  }
                });
              });
            }
          },
          error: function() {
            //alert('Error retrieving games');
            $('#message-container').html('<p>No games yet.</p>');
            $('#game-number').hide();
          }
        });
      }


      $('.game-button').click(function() {
        $('.game-button').removeClass('active');
        var statusID = $(this).data('status-id');
        var userID = 1;
        //console.log(statusID);
        $(this).addClass('active');
        fetchGames(statusID, userID);
      });

      // Fetch games of status 1 when the page loads
      fetchGames(<?= $_GET['status'] ?>, 1);

      // Remove 'active' class from all buttons
      $('.game-button').removeClass('active');

      // Add 'active' class to the button with the matching 'status-id'
      $('.game-button[data-status-id="' + <?= $_GET['status'] ?> + '"]').addClass('active');
    });
  </script>
</body>

</html>