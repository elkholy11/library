// Books specific JavaScript

// Initialize books page
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname.includes('/books')) {
        initializeBooksPage();
    }
});

function initializeBooksPage() {
    // Load initial data
    loadBooks();
    loadCategories();
    loadAuthors();
    
    // Setup event listeners
    setupBooksEventListeners();
}

function setupBooksEventListeners() {
    // Search input
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            currentPage = 1;
            loadBooks();
        }, 500));
    }
    
    // Filters
    const filters = ['categoryFilter', 'authorFilter', 'statusFilter'];
    filters.forEach(filterId => {
        const filter = document.getElementById(filterId);
        if (filter) {
            filter.addEventListener('change', function() {
                currentPage = 1;
                loadBooks();
            });
        }
    });
    
    // Form submission
    const bookForm = document.getElementById('bookForm');
    if (bookForm) {
        bookForm.addEventListener('submit', handleBookSubmit);
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('bookModal');
    if (event.target === modal) {
        closeBookModal();
    }
}

// Close modal with escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeBookModal();
    }
}); 