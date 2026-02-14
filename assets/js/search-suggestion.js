
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('article-search-input');
    const suggestionsList = document.getElementById('search-suggestions');

    if (!searchInput || !suggestionsList) return;

    let timeout = null;
    let currentFocus = -1;

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

    // Keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        const items = suggestionsList.getElementsByTagName('li');
        if (e.key === 'ArrowDown') {
            currentFocus++;
            addActive(items);
        } else if (e.key === 'ArrowUp') {
            currentFocus--;
            addActive(items);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (currentFocus > -1) {
                if (items) items[currentFocus].querySelector('a').click();
            }
        }
    });

    function addActive(items) {
        if (!items) return false;
        removeActive(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = items.length - 1;
        items[currentFocus].classList.add('active');
        
        // Scroll to active item if needed
        const activeItem = items[currentFocus];
        if (activeItem) {
            activeItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function removeActive(items) {
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('active');
        }
    }

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
                currentFocus = -1; // Reset focus whenever results are updated

                if (results.length > 0) {
                    suggestionsList.style.display = 'block';
                    results.forEach(item => {
                        const li = document.createElement('li');
                        const a = document.createElement('a');
                        a.href = item.url;
                        
                        // Decode HTML entities in the title
                        let decodedTitle = decodeHTMLEntities(item.title);
                        
                        // Highlight search query
                        // Create a regex that is case-insensitive
                        const regex = new RegExp(`(${query})`, 'gi');
                        const highlightedTitle = decodedTitle.replace(regex, '<strong>$1</strong>');
                        
                        a.innerHTML = highlightedTitle;
                        li.appendChild(a);
                        suggestionsList.appendChild(li);
                    });
                } else {
                    suggestionsList.style.display = 'block';
                    const li = document.createElement('li');
                    li.classList.add('no-results');
                    li.textContent = '該当する記事は見つかりませんでした';
                    suggestionsList.appendChild(li);
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
