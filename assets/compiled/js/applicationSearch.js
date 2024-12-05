document.addEventListener('DOMContentLoaded', function() {
  // Get the search input and all application cards
  const searchInput = document.getElementById('searchInput');
  const applicationCards = document.querySelectorAll('.application-card');

  // Listen for input changes
  searchInput.addEventListener('input', function() {
    const searchValue = searchInput.value.toLowerCase();

    // Loop through each application card and toggle visibility based on the search value
    applicationCards.forEach(function(card) {
      const appName = card.getAttribute('data-application-name').toLowerCase();
      if (appName.includes(searchValue)) {
        card.style.display = ''; // Show the card
      } else {
        card.style.display = 'none'; // Hide the card
      }
    });
  });
});