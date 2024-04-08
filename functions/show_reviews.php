<?php
function showReviews($gameID)
{
    if ($gameID == 0) {
        echo "No reviews available";
    } else {
        global $db; // Use the $conn from the included connection file

        // Prepare the SQL statement
        $sql = "SELECT users.userName, avatars.link, reviews.reviewText, reviews.rating, reviews.reviewDate 
        FROM reviews 
        JOIN users ON reviews.userID = users.userID 
        JOIN useravatar ON users.userID = useravatar.userID 
        JOIN avatars ON useravatar.avatarID = avatars.avatarID
        WHERE reviews.gameID = ? AND (reviews.reviewText IS NOT NULL OR reviews.rating IS NOT NULL)";


        /* $sql = "SELECT users.firstname, users.lastname, userphoto.photo, reviews.ReviewText, reviews.Rating, reviews.ReviewDate 
    FROM reviews 
    JOIN users ON reviews.UserID = users.user_id 
    JOIN userphoto ON users.user_id = userphoto.user_id 
    WHERE reviews.BookID = ?"; */

        // Create a prepared statement
        $stmt = $db->prepare($sql);

        // Bind parameters
        $stmt->bind_param("i", $gameID);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();


        if ($result->num_rows != 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="d-flex align-items-center mt-3">';
                echo '<img src="' . $row['link'] . '" class="mr-3 rounded d-block" alt="Profile Photo" style="width: 50px; height: 50px; margin-right: 15px;" />';
                echo '<div>';
                echo '<h5 class="mt-0 mb-0">' . $row['userName'] . '</h5>';
                echo '<div class="rating">';
                for ($i = 0; $i < $row['rating']; $i++) {
                    echo '<span class="fa fa-star checked"></span>';
                }
                for ($i = $row['rating']; $i < 5; $i++) {
                    echo '<span class="fa fa-star"></span>';
                }
                echo '</div></div></div>';
                echo '<div class="ml-5" style="margin-top: 13px;">';
                echo '<p>' . htmlspecialchars($row['reviewText']) . '</p>';
                echo '<small class="text-muted">Posted on ' . $row['reviewDate'] . '</small>';
                echo '<hr></div>';
            }
        } else {
            echo "No reviews available";
        }
    }
}
