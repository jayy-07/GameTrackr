<!DOCTYPE html>
<html lang="en">
<?php include '../settings/core.php'; ?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Search results for "<?php echo $_GET['query']; ?>"</title>
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
  <div style="font-family: Bahnschrift" class="container mt-4">
    <h2>Search</h2>
    <div id="game-number">
      <p>Search results for "<?= htmlspecialchars($_GET['query']); ?>"</p>
      <span id="resultsLength"></span>

    </div>
    <div style="display: flex; justify-content: center; align-items: center; height: 50vh;" id="loading">
      <div class="spinner-border m-5" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <br />

    <!-- Game Cards -->
    <div id="results"></div>
    <button id="loadMore">Load More</button>
  </div>
  <footer class="page-footer navbar-expand-lg navbar-dark bg-dark">
    <p>Powered by <a href="https://www.giantbomb.com/" target="_blank">GiantBomb</a></p>
  </footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../js/search.js"></script>
<script>
  $(document).ready(function() {
    $('#loadMore').hide(); // Load initial results
  });

  $('#loadMore').off('click').on('click', function() {
    loadResults();
  });


  var page = 1; // Initialize page variable

  function loadResults() {
    var searchTerm = '<?php echo $_GET['query']; ?>';
    var url = 'https://www.giantbomb.com/api/search/?api_key=5743a53a52963939cd8a825b048a39af6bd172a0&format=jsonp&json_callback=?&query=' + searchTerm + '&resources=game&page=' + page;

    // Show loading button
    $("#loading").show();

    $.ajax({
      url: url,
      method: 'GET',
      dataType: 'jsonp',
      success: function(data) {
        $('#resultsLength').text(+data.number_of_total_results + " results");

        // Hide loading button
        $("#loading").hide();

        if (data.results.length > 0) { // Check if there are results
          $.each(data.results, function(i, item) {
            var release_year = item.expected_release_year ? item.expected_release_year : "";
            $('#results').append(
              '<a href="game_page.php?guid=' + item.guid + '" id="search-link">' +
              '<div class="search-item">' +
              '<img src="' + item.image.thumb_url + '" alt="Game Cover" class="search-game-cover" />' +
              '<div class="game-info">' +
              '<p>' + item.name + '</p>' +
              '<p>' + release_year + '</p>' +
              '</div>' +
              '</div>' +
              '</a>'
            );
          });

          // Calculate remaining results
          var remainingResults = data.number_of_total_results - (page * 10);

          if (remainingResults == 0) {
            $('#loadMore').hide();
          } else {
            $('#loadMore').show();
            page += 1;
          }
        } else {
          $('#loadMore').hide();
        }
      },
      error: function() {
        // Hide loading button
        $("#loading").hide();
        //alert('Error retrieving data');
      }
    });
  }
</script>

</html>