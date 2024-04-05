<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Game Collection</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png">
    <!-- Include Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
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
        background-color: #ff0000; /* Red color (you can adjust this) */
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
                  <a class="dropdown-item" href="games.php">Played</a>
                  <a class="dropdown-item" href="games.php">Playing</a>
                  <a class="dropdown-item" href="games.php">Backlog</a>
                  <a class="dropdown-item" href="games.php">Wishlist</a>
                  <a class="dropdown-item" href="friends.html">Friends</a>
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
      <div class="mb-5">
        <form class="form-inline my-2 my-lg-0 d-flex">
            <input
              id="search-input"
              class="form-control me-2"
              type="search"
              placeholder="Search your library"
              aria-label="Search"
            />
          </form>
      </div>
      <div class="mb-4">
        <button class="btn game-button active">
          Played
        </button>
        <button class="btn game-button">Playing</button>
        <button class="btn game-button">Backlog</button>
        <button class="btn game-button">Wishlist</button>
      </div>

      <!-- Game Cards -->
      <div class="row">
        <div id="game-number"><p>6 games</p></div>
        <div class="col-md-3">
          <div class="card game-card">
            <a href="#">
              <img src="game_cover.jpg" alt="Game Title" class="game-cover" />
              <div class="card-body">
                <h5 class="card-title">Game Title</h5>
              </div>
            </a>
          </div>
        </div>
        <!-- Repeat similar game cards for other games -->
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>