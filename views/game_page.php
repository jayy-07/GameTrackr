<?php
session_start();
include_once '../settings/connection.php';
include '../functions/show_reviews.php';
$_POST['new'] = 1;
$userID = 1;

$query = "SELECT gameID FROM games WHERE guid = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $_GET['guid']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  $gameID = $result->fetch_assoc()['gameID'];
} else {
  $gameID = 0;
}

$_SESSION['gameID'] = $gameID;


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

if ($gameID == 0) {
  $reviewText = '';
  $rating = null;
} else {
  $query = "SELECT reviewText, rating FROM reviews WHERE userID = ? AND gameID = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param('ii', $userID, $gameID);
  $stmt->execute();
  $result = $stmt->get_result();
  $review = $result->fetch_assoc();

  $reviewText = isset($review['reviewText']) ? $review['reviewText'] : '';
  //echo $reviewText;
  $rating = isset($review['rating']) ? $review['rating'] : null;

  $stmt->close();
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
            echo '<button class="btn btn-outline-danger mt-3 active" id="delete-button" style="display: flex; justify-content: center; width: 100%;">🗑️ Delete from library</button>';
          }

          ?>
        </div>

        <?php
        $result = $db->query("SELECT * FROM wishlists WHERE userID = '$userID' AND gameID = '$gameID'");
        if ($result->num_rows > 0) {
          echo '<button class="btn btn-outline-danger mt-3 active" id="wishlist" style="display: flex; justify-content: center; width: 100%;">
            🗑️ Remove from Wishlist
          </button>';
        } else {
          echo '<button class="btn btn-outline-danger mt-3" id="wishlist" style="display: flex; justify-content: center; width: 100%;">
            🌟 Add to Wishlist
          </button>';
        }

        ?>
        <br /><br />
        <div id="full-stars-example" style="margin-left: 5%;">
          <div class="rating-group">
            <input class="rating__input rating__input--none" name="rating" id="rating-none" value="0" type="radio" <?= $rating === null || $rating === 0 ? 'checked' : '' ?>>
            <label aria-label="No rating" class="rating__label" for="rating-none"><i class="rating__icon rating__icon--none fa fa-ban"></i></label>
            <?php for ($i = 1; $i <= 5; $i++) : ?>
              <label aria-label="<?= $i ?> star" class="rating__label" for="rating-<?= $i ?>"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
              <input class="rating__input" name="rating" id="rating-<?= $i ?>" value="<?= $i ?>" type="radio" <?= $i == $rating ? 'checked' : '' ?>>
            <?php endfor; ?>
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
          <div style="font-size: 15px;" id="description">
          </div>
          <span id="genres" style="color: #777"></span>
          <br />
          <span id="platforms" style="color: #777"></span>
          <br />
          <span style="color: #777" id="release-year"></span>
        </div>
        <hr />
        <h4 style="font-family: Bahnschrift">Make a Review</h4>
        <textarea id="reviewText" class="form-control" rows="3" maxlength="4000" placeholder="What'd you think..."><?= htmlspecialchars($reviewText) ?></textarea>

        <br />
        <div id="alert"></div>
        <button id="submitReview" class="btn mt-3">
          Submit Review
        </button>
        <hr />

        <h4>Reviews</h4>
        <div id="reviews">
          <?php showReviews($gameID); ?>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var guid = '<?php echo $_GET['guid']; ?>';
      console.log(guid);
      var url = 'https://www.giantbomb.com/api/game/' + guid + '/?api_key=5743a53a52963939cd8a825b048a39af6bd172a0&format=jsonp&json_callback=?';

      $.ajax({
        url: url,
        method: 'GET',
        dataType: 'jsonp',
        success: function(data) {
          $('#game-cover').attr('src', data.results.image.medium_url);
          $('#cover-image').attr('src', data.results.images[1]?.original || data.results.images[0].original);
          $('#title').text(data.results.name);
          $('#publisher').text(data.results.publishers[0].name);
          $('#genres').text("Genres: " + data.results.genres.map(genre => genre.name).join(', '));
          $('#platforms').text("Platforms: " + data.results.platforms.map(platform => platform.name).join(', '));
          var releaseYear = data.results.original_release_date ? new Date(data.results.original_release_date).getFullYear() : data.results.expected_release_year;
          $('#release-year').text("Release year: " + releaseYear);


          if (data.results.description) {
            var description = data.results.description.replace(/<a[^>]*>(.*?)<\/a>/g, "$1").replace(/<img[^>]*>/g, "");
            var maxLength = 1600; // Maximum number of characters to display
            var shortText = description.substr(0, maxLength);
            console.log(shortText);
            var longText = description.substr(maxLength);
            console.log(longText);
            $('#description').html(shortText + '<br><span><a href="#" class="readMore">Read More</a></span>');

            $(document).on('click', '.readMore', function(e) {
              e.preventDefault();
              $(this).hide();
              $('#description').html(shortText + longText + '<a href="#" class="readLess">Read Less</a>');
            });

            $(document).on('click', '.readLess', function(e) {
              e.preventDefault();
              $('#description').html(shortText + '<br><span><a href="#" class="readMore">Read More</a></span>');
            });
          } else {
            $('#description').html("No description available");
          }
        },
        error: function() {
          alert('Error retrieving data');
        }
      });


      $('#delete-div').on('click', '#delete-button', function() {
        var gameID = '<?= $gameID ?>';
        var userID = 1;

        $.ajax({
          url: '../actions/delete_game.php',
          type: 'POST',
          data: {
            'gameID': gameID,
            'userID': userID
          },
          success: function(response) {
            appendAlert('Game deleted successfully.', 'success');
            $('#delete-button').hide();
            $('#button-group input[type="radio"]').prop('checked', false);
          },
          error: function(xhr, status, error) {
            appendAlert('An error occurred: ' + error, 'danger');
          }
        });
      });

      $('input[type=radio][name=playingStatus]').change(function() {
        var status = this.value;
        var guid = '<?= $_GET["guid"] ?>';
        $.ajax({
          url: '../actions/update_status.php',
          type: 'POST',
          data: {
            'status': status,
            'guid': guid
          },
          success: function(response) {
            //alert('Status updated successfully.');
            appendAlert('Status updated successfully.', 'success');
            if ('1' == <?= $_POST['new'] ?>) {
              var div = document.getElementById('delete-div');
              div.innerHTML = '<button class="btn btn-outline-danger mt-3 active" id="delete-button" style="display: flex; justify-content: center; width: 100%;">🗑️ Delete from library</button>';
            } else {
              $('#delete-button').show();
            }


          },
          error: function(xhr, status, error) {
            appendAlert('An error occurred: ' + error, 'danger');
            alert('An error occurred: ' + error);
          }
        });
      });

      var gameID = '<?= $gameID ?>';
      var userID = 1;
      var guid = '<?= $_GET["guid"] ?>';


      // Add or remove the game from the wishlist when the button is clicked
      $('#wishlist').click(function() {
        $.ajax({
          url: '../actions/wishlist.php',
          type: 'POST',
          data: {
            userID: userID,
            'guid': guid
          },
          success: function updateButton(data) {
            if (data == "added") {
              $('#wishlist').text('🗑️ Remove from Wishlist');
              $('#wishlist').addClass('active');
              appendAlert('Added to your wishlist', 'success');
            } else {
              $('#wishlist').text('🌟 Add to Wishlist');
              $('#wishlist').removeClass('active');
              appendAlert('Removed from your wishlist', 'success');

            }
          }
        });
      });

      // Event handler for rating change
      $('input[name=rating]').change(function() {
        var rating = $(this).val();
        var gameId = <?= $gameID ?>;
        var userId = <?= $userID ?>;
        var guid = '<?= $_GET["guid"] ?>';

        // If the "No rating" radio button is selected, set rating to null
        if (rating === 'no-rating') {
          rating = 0;
        }

        $.ajax({
          url: '../actions/submit_review.php',
          type: 'post',
          data: {
            'rating': rating,
            'userID': userID,
            'guid': guid
          },
          success: function(response) {
            $('#alert').html('<div class="alert alert-dismissible alert-success" role="alert">' + response + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
          }
        });
      });

      // Event handler for review submission
      $('#submitReview').click(function() {
        var reviewText = $('#reviewText').val();
        var gameId = <?= $gameID ?>;
        var userId = <?= $userID ?>;
        var guid = '<?= $_GET["guid"] ?>';

        // Include the current rating
        var rating = $('input[name=rating]:checked').val();
        if (rating === 'no-rating') {
          rating = 0;
        }

        $.ajax({
          url: '../actions/submit_review.php',
          type: 'post',
          data: {
            'reviewText': reviewText,
            'rating': rating,
            'gameID': gameID,
            'userID': userID,
            'guid': guid
          },
          success: function(response) {
            $('#alert').html('<div class="alert alert-dismissible alert-success" role="alert">' + response + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
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