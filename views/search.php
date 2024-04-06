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
  <style>
    #search-link {
      text-decoration: none;
      color: black;
    }

    .search-item {
      display: flex;
      align-items: center;
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .search-item:hover {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .search-game-cover {
      width: 100px;
      height: 140px;
      object-fit: cover;
      margin-right: 30px;
      border-radius: 5px;
    }

    .game-info p {
      margin: 0;
    }

    .game-info p:first-child {
      font-weight: bold;
      margin-bottom: 5px;
    }

    #loadMore {
      margin-left: 45%;
      border: 2px solid transparent;
      padding: 8px 15px;
      margin-right: 10px;
      font-weight: bold;
      transition: background-color 0.3s, border-color 0.3s;
      background-color: #ff0000;
      color: white;
      border-radius: 5px;
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
  <div style="font-family: Bahnschrift" class="container mt-4">
    <h2>Search</h2>
    <div id="game-number">
      <p>Search results for "<?= htmlspecialchars($_POST['query']); ?>"</p>
      <span id="resultsLength"></span>

    </div>
    <div class="spinner-border m-5" role="status" id="loading"> <span class="visually-hidden">Loading...</span></div>
    <br />

    <!-- Game Cards -->
    <div id="results"></div>
    <button id="loadMore">Load More</button>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../js/search.js"></script>
<script>
  var page = 1;

  $(document).ready(function() {
    loadResults(); // Load initial results
  });

  $('#loadMore').on('click', function() {
    page += 1; // Go to next page of results
    loadResults();
  });

  function loadResults() {
    var searchTerm = '<?php echo $_POST['query']; ?>';
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
          // Show Load More button after results are loaded
          $('#loadMore').show();
        } else {
          // Hide Load More button if there are no more results
          $('#loadMore').hide();
        }
      },
      error: function() {
        // Hide loading button
        $("#loading").hide();
        alert('Error retrieving data');
      }
    });
  }
</script>

</html>