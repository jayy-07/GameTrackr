<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Game Collection</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png" />
    <!-- Include Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="../css/home.css" rel="stylesheet" />
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <a
            class="navbar-brand font-weight-bold"
            id="logo-text"
            href="dashboard.php"
            >gametrackr</a
          >
          <ul
            class="navbar-nav w-100 d-flex align-items-center"
            id="navbar-right"
          >
            <ul class="navbar-nav mr-auto">
              <li class="nav-item dropdown" id="dropdown-menu">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="userDropdown"
                  role="button"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  joeyskillz
                </a>
                <div class="dropdown-menu" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#">Profile</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="dashboard.php">Dashboard</a>
                  <a class="dropdown-item" href="games.php?status=1">Played</a>
                  <a class="dropdown-item" href="games.php?status=2">Playing</a>
                  <a class="dropdown-item" href="games.php?status=3">Backlog</a>
                  <a class="dropdown-item" href="games.php?status=4"
                    >Wishlist</a
                  >
                  <a class="dropdown-item" href="friends.php">Friends</a>
                  <a class="dropdown-item" href="#">Reviews</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Log Out</a>
                </div>
              </li>
            </ul>
            <form
              class="form-inline my-2 my-lg-0 d-flex"
              method="post"
              action="../views/search.php"
            >
              <input
                id="search-input"
                class="form-control me-2"
                type="search"
                name="query"
                placeholder="Search for games"
                aria-label="Search"
              />
              <button id="search-btn" class="btn" type="submit">Search</button>
            </form>
          </ul>
        </div>
      </nav>
    </header>
  </body>
</html>
