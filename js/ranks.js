document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('leaderboardSearch');
  const rows = document.querySelectorAll(
    '#leaderboardBody .leaderboard-row:not(.no-data-row):not(.no-results-row)'
  );
  const noResults = document.getElementById('noSearchResults');

  searchInput?.addEventListener('input', (e) => {
    const query = e.target.value.toLowerCase().trim();
    let visibleCount = 0;

    rows.forEach((row) => {
      const username = row.querySelector('.username-col')?.textContent.toLowerCase() || '';
      if (username.includes(query)) {
        row.style.display = 'grid';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    if (noResults) {
      noResults.style.display = visibleCount === 0 && rows.length > 0 ? 'grid' : 'none';
    }
  });
});
