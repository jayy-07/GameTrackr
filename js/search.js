
var page = 1; 

$(document).ready(function() {
  loadResults(); // Load initial results
});

$('#loadMore').on('click', function() {
  page += 1; // Go to next page of results
  loadResults();
});

function loadResults() {
  var searchTerm = '<?php echo $_POST["query"]; ?>';
  var url = 'https://www.giantbomb.com/api/search/?api_key=5743a53a52963939cd8a825b048a39af6bd172a0&format=jsonp&json_callback=?&query=' + searchTerm + '&resources=game&page=' + page;

  $.ajax({
    url: url,
    method: 'GET',
    dataType: 'jsonp',
    success: function(data) {
      $('#resultsLength').text(+data.number_of_total_results + " results");
      if (data.results.length > 0) { // Check if there are results
        $.each(data.results, function(i, item) {
          var release_year = item.expected_release_year ? item.expected_release_year : "Release year unavailable";
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
        $('#loadMore').show(); // Show Load More button after results are loaded
      } else {
        $('#loadMore').hide(); // Hide Load More button if there are no more results
      }
    },
    error: function() {
      alert('Error retrieving data');
    }
  });
}
