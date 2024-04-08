<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Game Collection</title>
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
                <a class="dropdown-item" href="reviews.php">My Reviews</a>
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
    <h2>Your Reviews</h2>
    <div class="container mt-5" id="review-container">
      <?php include "../functions/show_user_reviews.php"; ?>
    </div>
    <br>
  </div>

  <div class="modal fade" id="editReviewModal" tabindex="-1" role="dialog" aria-labelledby="editReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editReviewModalLabel">Edit Your Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Star Rating -->
          <div id="full-stars-example">
            <div class="rating-group">
              <input class="rating__input rating__input--none" name="rating" id="rating-none" value="0" type="radio">
              <label aria-label="No rating" class="rating__label" for="rating-none"><i class="rating__icon rating__icon--none fa fa-ban"></i></label>
              <?php for ($i = 1; $i <= 5; $i++) : ?>
                <label aria-label="<?= $i ?> star" class="rating__label" for="rating-<?= $i ?>"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                <input class="rating__input" name="rating" id="rating-<?= $i ?>" value="<?= $i ?>" type="radio">
              <?php endfor; ?>
            </div>
          </div>
          <!-- Review Text -->
          <textarea id="reviewText" class="form-control" rows="3" maxlength="4000" placeholder="What'd you think..."></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="saveChanges" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="deleteReviewModal" tabindex="-1" role="dialog" aria-labelledby="deleteReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteReviewModalLabel">Delete Your Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this review?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="button" id="saveChanges" class="btn btn-danger">Yes</button>
        </div>
      </div>
    </div>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('#review-container').on('click', '.btn-primary', function() {
      var userID = 1;
      var reviewID = $(this).data('review-id');
      console.log(reviewID);

      $.ajax({
        type: "POST",
        url: "../actions/fetch_review_info.php",
        data: {
          reviewID: reviewID,
          userID: userID
        },
        dataType: "json",
        success: function(data) {
          $('#reviewText').val(data.reviewText);
          $('input[name="rating"][value="' + data.rating + '"]').prop('checked', true);
          $('#editReviewModal').data('review-id', reviewID); // Store the reviewID in the modal
          $('#editReviewModal').modal('show');
        }
      });
    });

    $('#review-container').on('click', '.btn-danger', function() {
      var userID = 1;
      var reviewID = $(this).data('review-id');
      $('#deleteReviewModal').data('review-id', reviewID);
      console.log(reviewID);
    });


    $('#editReviewModal .btn-primary').click(function() {
      var reviewID = $('#editReviewModal').data('review-id'); // Retrieve the reviewID from the modal
      var reviewText = $('#reviewText').val();
      var rating = $('input[name="rating"]:checked').val();

      $.ajax({
        type: "POST",
        url: "../actions/edit_review.php",
        data: {
          reviewID: reviewID,
          reviewText: reviewText,
          rating: rating
        },
        success: function(response) {
          // Handle the response from the server
          console.log(reviewID);
          $('#editReviewModal').modal('hide');
          $('#review-container').empty();
          $('#review-container').load('../functions/show_user_reviews.php');
        }
      });
    });

    $('#deleteReviewModal .btn-danger').click(function() {
      var reviewID = $('#deleteReviewModal').data('review-id'); // Retrieve the reviewID from the modal
      var reviewText = $('#reviewText').val();
      var rating = $('input[name="rating"]:checked').val();

      $.ajax({
        type: "POST",
        url: "../actions/delete_review.php",
        data: {
          reviewID: reviewID,
          reviewText: reviewText,
          rating: rating
        },
        success: function(response) {
          // Handle the response from the server
          console.log(reviewID);
          $('#deleteReviewModal').modal('hide');
          $('#review-container').empty();
          $('#review-container').load('../functions/show_user_reviews.php');
        }
      });
    });

    
  });
</script>

</html>