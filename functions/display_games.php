<?php
    include '../settings/connection.php';

    // Get the user ID and status ID
    $userID = 1;
    $statusID = 1;

    // Define your API key
    $api_key = '5743a53a52963939cd8a825b048a39af6bd172a0';

    // Define the base URL for the Giant Bomb API
    $base_url = 'https://www.giantbomb.com/api/game/';

    // Fetch the game IDs from the database
    $stmt = $db->prepare('SELECT gameID FROM usergames WHERE userID = ? AND statusID = ?');
    $stmt->bind_param('ii', $userID, $statusID);
    $stmt->execute();
    $result = $stmt->get_result();
    $gameIDs = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch the game data from the API and generate the HTML for each game
    foreach ($gameIDs as $game) {
        // Fetch the guid for the game from the database
        $stmt = $db->prepare('SELECT guid FROM games WHERE gameID = ?');
        $stmt->bind_param('i', $game['gameID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $guid = $result->fetch_assoc()['guid'];

        // Fetch the game data from the API
        $url = $base_url . $guid . '/?api_key=' . $api_key . '&format=jsonp&json_callback=mycallback';
        echo '<script src="'. $url . '"></script>';
    }
?>

<script>
function mycallback(response) {
    var game_data = response;
    var game_title = game_data.results.name;
    var game_publisher = game_data.results.publishers[0].name;
    var game_cover = game_data.results.image.medium_url;
    var game_link = 'game_page.php?guid=' + game_data.results.guid;

    var html = `
        <div class="col-md-3">
            <div class="card game-card">
                <a href="${game_link}">
                    <img src="${game_cover}" alt="${game_title}" class="game-cover" />
                    <div class="card-body">
                        <h5 class="card-title">${game_title}</h5>
                        <p class="card-text">${game_publisher}</p>
                    </div>
                </a>
            </div>
        </div>
    `;

    document.body.innerHTML += html;
}
</script>
