
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('article-search-input');
    const suggestionsList = document.getElementById('search-suggestions');

    if (!searchInput || !suggestionsList) return;

    let timeout = null;

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        // Clear previous timeout
        if (timeout) clearTimeout(timeout);

        if (query.length < 2) {
            suggestionsList.innerHTML = '';
            suggestionsList.style.display = 'none';
            return;
        }

        // Debounce
        timeout = setTimeout(() => {
            fetchSuggestions(query);
        }, 300);
    });

    function fetchSuggestions(query) {
        // Use the global search endpoint to find content across post types
        const url = `${inspiroSearch.root}wp/v2/search?search=${encodeURIComponent(query)}&per_page=5`;

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(results => {
                suggestionsList.innerHTML = '';
                if (results.length > 0) {
                    suggestionsList.style.display = 'block';
                    results.forEach(item => {
                        const li = document.createElement('li');
                        const a = document.createElement('a');
                        a.href = item.url;
                        // Decode HTML entities (e.g., &#8211;) in the title
                        a.textContent = decodeHTMLEntities(item.title);
                        li.appendChild(a);
                        suggestionsList.appendChild(li);
                    });
                } else {
                    suggestionsList.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
                suggestionsList.style.display = 'none';
            });
    }

    function decodeHTMLEntities(text) {
        const textArea = document.createElement('textarea');
        textArea.innerHTML = text;
        return textArea.value;
    }

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
            suggestionsList.style.display = 'none';
        }
    });
});
