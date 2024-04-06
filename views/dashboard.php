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

  <div class="container mt-4">

    <!-- Dashboard -->
    <div class="container">
      <h2>Dashboard</h2>
      <div class="row">
        <div class="col-md-3">
          <div class="card stat-card">
            <a href="games.html">
              <div class="card-body">
                <span class="stat-icon">📝</span>
                <h5 class="card-title">Reviews</h5>
                <p class="card-text" id="reviews-count">0</p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card">
            <a href="games.html">
              <div class="card-body">
                <span class="stat-icon">🎮</span>
                <h5 class="card-title">Played</h5>
                <p class="card-text" id="played-count">0</p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card">
            <a href="games.html">
              <div class="card-body">
                <span class="stat-icon">📅</span>
                <h5 class="card-title">Backlog</h5>
                <p class="card-text" id="backlog-count">0</p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stat-card">
            <a href="'games.html">
              <div class="card-body">
                <span class="stat-icon">🌟</span>
                <h5 class="card-title">Wishlist</h5>
                <p class="card-text" id="wishlist-count">0</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div id="results"></div>


    <div class="col-md-12 mt-5">
      <h4>Recent Games</h4>
      <br />
      <div class="row gx-4">
        <!-- Game Card -->
        <div class="col-md-2">
          <div class="card">
            <a href="#">
              <img src="https://www.giantbomb.com/a/uploads/scale_small/16/164924/3564705-1228401694-76f46.png" class="card-img-top" alt="game image" />
              <div class="card-body">
                <h5 class="card-title">Game Title</h5>
              </div>
            </a>
          </div>
        </div>
        <!-- Repeat game card for each game -->
      </div>
    </div>
  </div>

  <!-- Include Bootstrap JS (at the end of the body) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    /* $(document).ready(function() {
      $('#search-btn').click(function(e) {
        e.preventDefault();
        var searchQuery = $('#search-input').val();
        var apiKey = '5743a53a52963939cd8a825b048a39af6bd172a0';
        var url = 'https://www.giantbomb.com/api/search/?format=jsonp&api_key=' + apiKey + '&query=' + searchQuery;

        $.ajax({
          url: url,
          method: 'GET',
          dataType: 'jsonp',
          jsonp: 'json_callback',
          success: function(data) {
            // Clear previous results
            $('#results').empty();

            // Loop through the results and append them to the #results div
            $.each(data.results, function(i, item) {
              $('#results').append('<p>' + item.name + '</p>');
            });
          },
          error: function() {
            alert('Error retrieving data');
          }
        });
      });
    }); */
  </script>
</body>

</html>