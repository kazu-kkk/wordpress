
document.addEventListener('DOMContentLoaded', function() {
    // Initialize for desktop/PC
    setupSearchSuggestions('article-search-input', 'search-suggestions');
    // Initialize for mobile
    setupSearchSuggestions('article-search-input-mobile', 'search-suggestions-mobile');

    function setupSearchSuggestions(inputId, listId) {
        const searchInput = document.getElementById(inputId);
        const suggestionsList = document.getElementById(listId);

        if (!searchInput || !suggestionsList) return;

        let timeout = null;
        let currentFocus = -1;

        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            if (timeout) clearTimeout(timeout);

            if (query.length < 2) {
                suggestionsList.innerHTML = '';
                suggestionsList.style.display = 'none';
                return;
            }

            timeout = setTimeout(() => {
                fetchSuggestions(query, suggestionsList);
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
                    if (items && items[currentFocus]) {
                        items[currentFocus].querySelector('a').click();
                    }
                }
            }
        });

        function addActive(items) {
            if (!items) return false;
            removeActive(items);
            if (currentFocus >= items.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = items.length - 1;
            items[currentFocus].classList.add('active');
            
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

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    }

    function fetchSuggestions(query, suggestionsList) {
        // Use the global search endpoint to find content across post types
        // Note: inspiroSearch must be defined globally via wp_localize_script
        if (typeof inspiroSearch === 'undefined') return;
        
        const url = `${inspiroSearch.root}wp/v2/search?search=${encodeURIComponent(query)}&per_page=5`;

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(results => {
                suggestionsList.innerHTML = '';
                // Since this function is async and separate from the input object, we rely on event listeners for focus management
                
                if (results.length > 0) {
                    suggestionsList.style.display = 'block';
                    results.forEach(item => {
                        const li = document.createElement('li');
                        const a = document.createElement('a');
                        a.href = item.url; // Ensure 'url' is the correct property from WP API
                        
                        let title = item.title;
                        // Use regex to highlight query
                        const regex = new RegExp(`(${query})`, 'gi');
                        const highlightedTitle = title.replace(regex, '<strong>$1</strong>');
                        
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
});
