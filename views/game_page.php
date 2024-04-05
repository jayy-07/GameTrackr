<?php
include_once '../settings/connection.php';
$_POST['new'] = 1;
$userID = 1;

$query = "SELECT gameID FROM games WHERE guid = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $_GET['guid']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  $gameID = $result->fetch_assoc()['gameID'];
}

// Fetch the statusID for the game and user
$query = "SELECT statusID FROM usergames WHERE userID = ? AND gameID = (SELECT gameID FROM games WHERE guid = ?)";
$stmt = $db->prepare($query);
$stmt->bind_param("is", $userID, $_GET['guid']);
$stmt->execute();
$result = $stmt->get_result();
$gameStatusID = $result->fetch_assoc()['statusID'] ?? 'None'; // Default to 'None' if no status is set
$stmt->close();

// Define the status categories
$status = [
  'played' => "1",
  'playing' => "2",
  'backlog' => "3",
  'None' => "None"
];

// Function to check if the radio button should be checked
function isChecked($gameStatusID, $statusID)
{
  return $gameStatusID == $statusID ? "checked" : "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Game Page</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png" />
  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <a class="dropdown-item" href="games.html">Played</a>
                <a class="dropdown-item" href="games.html">Playing</a>
                <a class="dropdown-item" href="games.html">Backlog</a>
                <a class="dropdown-item" href="games.html">Wishlist</a>
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
  <!-- Game Cover Image -->
  <div class="game-cover-art">
    <img src="#" class="cover-image" id="cover-image" height="400px" width="100%" style="object-fit: cover" />
  </div>

  <!-- Game Content -->
  <div class="container game-content custom-container mt-5">
    <div class="row custom-row">
      <div class="col-3">
        <img src="#" class="img-fluid" id="game-cover" alt="Game Cover" />
        <br /><br />
        <div>
          <div id="button-group" class="btn-group mt-4" role="group" aria-label="Playing Status" style="display: flex; justify-content: center; width: 100%;">
            <input type="radio" class="btn-check" name="playingStatus" id="played" value="1" <?= isChecked($gameStatusID, $status['played']) ?>>
            <label class="btn btn-outline-danger" for="played">Played</label>
            <input type="radio" class="btn-check" name="playingStatus" id="playing" value="2" <?= isChecked($gameStatusID, $status['playing']) ?>>
            <label class="btn btn-outline-danger" for="playing">Playing</label>
            <input type="radio" class="btn-check" name="playingStatus" id="backlog" value="3" <?= isChecked($gameStatusID, $status['backlog']) ?>>
            <label class="btn btn-outline-danger" for="backlog">Backlog</label>
          </div>
          <br>
          <div id="liveAlertPlaceholder"></div>

        </div>


        <div id="delete-div">
          <?php
          // Check if the game is in the user's library
          $query = "SELECT * FROM usergames WHERE gameID = ? AND userID = ?";
          $stmt = $db->prepare($query);
          $stmt->bind_param("ii", $gameID, $userID); // Assuming you store the user's ID in session
          $stmt->execute();
          $result = $stmt->get_result();
          if ($result->num_rows > 0) {
            // The game is in the user's library, show the delete button
            echo '<button class="btn btn-outline-danger mt-3" id="delete-button" style="display: flex; justify-content: center; width: 100%;">🗑️ Delete from library</button>';
          }

          ?>
        </div>

        <button class="btn btn-outline-danger mt-3" id="wishlist" style="display: flex; justify-content: center; width: 100%;">
          🌟 Add to Wishlist
        </button>
        <br /><br />
        <div id="full-stars-example">
          <div class="rating-group">
            <input class="rating__input rating__input--none" name="rating" id="rating-none" value="0" type="radio" />
            <label aria-label="No rating" class="rating__label" for="rating-none"><i class="rating__icon rating__icon--none fa fa-ban"></i></label>
            <label aria-label="1 star" class="rating__label" for="rating-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
            <input class="rating__input" name="rating" id="rating-1" value="1" type="radio" />
            <label aria-label="2 stars" class="rating__label" for="rating-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
            <input class="rating__input" name="rating" id="rating-2" value="2" type="radio" />
            <label aria-label="3 stars" class="rating__label" for="rating-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
            <input class="rating__input" name="rating" id="rating-3" value="3" type="radio" checked />
            <label aria-label="4 stars" class="rating__label" for="rating-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
            <input class="rating__input" name="rating" id="rating-4" value="4" type="radio" />
            <label aria-label="5 stars" class="rating__label" for="rating-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
            <input class="rating__input" name="rating" id="rating-5" value="5" type="radio" />
          </div>

        </div>
      </div>
      <div style="margin-left: 50px;" class="col-md-8">
        <div id="game-info">
          <h2 id="title"></h2>
          <p style="color: #000000">
            by <strong id="publisher"></strong>
          </p>
          <br />
          <p style="font-size: 15px;" id="description">
          </p>
          <span id="genres" style="color: #777"></span>
          <br />
          <span id="platforms" style="color: #777"></span>
          <br />
          <span style="color: #777" id="release-year"></span>
        </div>
        <hr />
        <h4 style="font-family: Bahnschrift">Make a Review</h4>
        <textarea id="reviewText" class="form-control" rows="3" maxlength="4000" placeholder="What'd you think..."></textarea>

        <br />
        <div id="alert"></div>
        <button id="submitReview" class="btn mt-3">
          Submit Review
        </button>
        <hr />

        <h4>Reviews</h4>
        <div class="media mt-3">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReHlx51nzRyT2IGzXt9Ow0uUOOTCEAXlPejZhQLm1aAw&s" class="mr-3 rounded-circle" alt="Profile Photo" style="width: 40px; height: 40px" />
          <div class="media-body">
            <h5 class="mt-0">John Doe</h5>
            <div class="rating">
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star"></span>
              <span class="fa fa-star"></span>
            </div>
            <p>This is a sample review text.</p>
            <small class="text-muted">Posted on 2024-04-03</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Bootstrap JS (at the end of the body) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var guid = '<?php echo $_GET['guid']; ?>';
      var url = 'https://www.giantbomb.com/api/game/' + guid + '/?api_key=5743a53a52963939cd8a825b048a39af6bd172a0&format=jsonp&json_callback=?';

      $.ajax({
        url: url,
        method: 'GET',
        dataType: 'jsonp',
        success: function(data) {
          $('#game-cover').attr('src', data.results.image.medium_url);
          if (data.results.images[1].original) {
            $('#cover-image').attr('src', data.results.images[1].original);
          } else {
            $('#cover-image').attr('src', data.results.images[0].original);
          }
          $('#title').text(data.results.name);
          $('#publisher').text(data.results.publishers[0].name);
          if (data.results.description) {
            $('#description').html(data.results.description.replace(/<a[^>]*>(.*?)<\/a>/g, "$1").replace(/<img[^>]*>/g, ""));
          } else {
            $('#description').html("");
          }
          $('#genres').text("Genres: " + data.results.genres.map(genre => genre.name).join(', '));
          $('#platforms').text("Platforms: " + data.results.platforms.map(platform => platform.name).join(', '));
          $('#release-year').text("Release year: " + data.results.expected_release_year);
        },
        error: function() {
          alert('Error retrieving data');
        }
      });
    });

    $(document).ready(function() {
      // Assuming 'delete-div' is the parent element of your delete button
      $('#delete-div').on('click', '#delete-button', function() {
        var gameID = '<?= $gameID ?>'; // Make sure this variable is set to the current game's ID
        var userID = 1; // Make sure this variable is set to the current user's ID $_SESSION["userID"]

        $.ajax({
          url: '../actions/delete_game.php', // The server-side script to handle the deletion
          type: 'POST',
          data: {
            'gameID': gameID,
            'userID': userID
          },
          success: function(response) {
            // Show a success alert
            appendAlert('Game deleted successfully.', 'success');
            $('#delete-button').hide();
            $('#button-group input[type="radio"]').prop('checked', false);
          },
          error: function(xhr, status, error) {
            // Show a danger alert
            appendAlert('An error occurred: ' + error, 'danger');
          }
        });
      });
    });



    $(document).ready(function() {
      $('input[type=radio][name=playingStatus]').change(function() {
        var status = this.value;
        var guid = '<?= $_GET["guid"] ?>'; // Make sure this variable is set to the current game's GUID 
        $.ajax({
          url: '../actions/update_status.php', // The server-side script to handle the update
          type: 'POST',
          data: {
            'status': status,
            'guid': guid
          },
          success: function(response) {
            //alert('Status updated successfully.');
            appendAlert('Status updated successfully.', 'success');
            if ('1' == <?= $_POST['new'] ?>) {
              var div = document.getElementById('delete-div')
              div.innerHTML = '<button class="btn btn-outline-danger mt-3" id="delete-button" style="display: flex; justify-content: center; width: 100%;">🗑️ Delete from library</button>';
            } else {
              $('#delete-button').show();
            }


          },
          error: function(xhr, status, error) {
            // Handle errors
            appendAlert('An error occurred: ' + error, 'danger');
            alert('An error occurred: ' + error);
          }
        });
      });
    });

    const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
    const appendAlert = (message, type) => {
      const wrapper = document.createElement('div')
      wrapper.innerHTML = [
        `<div class="alert alert-${type} alert-dismissible" role="alert">`,
        `   <div>${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
      ].join('')

      alertPlaceholder.append(wrapper)
    }
  </script>
</body>

</html>