document.addEventListener('DOMContentLoaded', function() {
    // Initialize for desktop/PC
    setupSearchSuggestions('article-search-input', 'search-suggestions');
    // Initialize for mobile
    setupSearchSuggestions('article-search-input-mobile', 'search-suggestions-mobile');

    function setupSearchSuggestions(inputId, listId) {
        const searchInput = document.getElementById(inputId);
        const suggestionsList = document.getElementById(listId);

        if (!searchInput || !suggestionsList) return;

        const form = searchInput.closest('form');
        let timeout = null;
        let currentFocus = -1;

        // Input handler (Incremental search)
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            currentFocus = -1;
            
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

        // Re-open suggestions on focus if query exists
        searchInput.addEventListener('focus', function() {
            const query = searchInput.value.trim();
            if (query.length >= 2 && suggestionsList.children.length > 0) {
                suggestionsList.style.display = 'block';
            }
        });

        // Form submit handler (Prevents empty query submission)
        if (form) {
            form.addEventListener('submit', function(e) {
                const query = searchInput.value.trim();
                if (!query) {
                    e.preventDefault();
                    return;
                }
                suggestionsList.style.display = 'none';
            });
        }

        // Keyboard navigation & Submission handling
        searchInput.addEventListener('keydown', function(e) {
            // IME変換中のEnterは無視（日本語入力確定を邪魔しない）
            if (e.isComposing || e.keyCode === 229) {
                return;
            }

            const items = suggestionsList.querySelectorAll('li:not(.no-results)');

            if (e.key === 'ArrowDown') {
                if (items.length > 0 && suggestionsList.style.display !== 'none') {
                    e.preventDefault();
                    currentFocus++;
                    addActive(items);
                }
            } else if (e.key === 'ArrowUp') {
                if (items.length > 0 && suggestionsList.style.display !== 'none') {
                    e.preventDefault();
                    currentFocus--;
                    addActive(items);
                }
            } else if (e.key === 'Enter') {
                // サジェスト項目が矢印キーで選択されている場合、その記事へ遷移
                if (currentFocus > -1 && items && items[currentFocus]) {
                    const link = items[currentFocus].querySelector('a');
                    if (link) {
                        e.preventDefault();
                        link.click();
                        return;
                    }
                }

                // サジェストを選択していない場合、検索結果一覧ページへ遷移
                const query = searchInput.value.trim();
                if (!query) {
                    e.preventDefault();
                    return;
                }

                e.preventDefault();
                suggestionsList.style.display = 'none';
                const homeUrl = (typeof inspiroSearch !== 'undefined' && inspiroSearch.homeUrl) ? inspiroSearch.homeUrl : (form ? form.getAttribute('action') : '/');
                const separator = (homeUrl && homeUrl.indexOf('?') !== -1) ? '&' : '?';
                window.location.href = `${homeUrl}${separator}s=${encodeURIComponent(query)}`;
            } else if (e.key === 'Escape') {
                suggestionsList.innerHTML = '';
                suggestionsList.style.display = 'none';
                currentFocus = -1;
            }
        });

        function addActive(items) {
            if (!items || items.length === 0) return false;
            removeActive(items);
            if (currentFocus >= items.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = items.length - 1;
            
            const activeItem = items[currentFocus];
            if (activeItem) {
                activeItem.classList.add('active');
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
                currentFocus = -1;
            }
        });
    }

    function fetchSuggestions(query, suggestionsList) {
        // Use the global search endpoint to find content across post types
        if (typeof inspiroSearch === 'undefined') return;
        
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
