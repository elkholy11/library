// Dashboard JavaScript

// Global variables
let currentPage = 1;
let totalPages = 1;

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    initializeDashboard();
});

function initializeDashboard() {
    // Add event listeners
    setupEventListeners();
    
    // Load initial data if on specific pages
    if (window.location.pathname.includes('/books')) {
        loadBooks();
        loadCategories();
        loadAuthors();
    }
}

function setupEventListeners() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            currentPage = 1;
            if (window.location.pathname.includes('/books')) {
                loadBooks();
            }
        }, 500));
    }

    // Filter functionality
    const categoryFilter = document.getElementById('categoryFilter');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            currentPage = 1;
            loadBooks();
        });
    }

    const authorFilter = document.getElementById('authorFilter');
    if (authorFilter) {
        authorFilter.addEventListener('change', function() {
            currentPage = 1;
            loadBooks();
        });
    }

    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            currentPage = 1;
            loadBooks();
        });
    }

    // Form submission
    const bookForm = document.getElementById('bookForm');
    if (bookForm) {
        bookForm.addEventListener('submit', handleBookSubmit);
    }
}

// API Functions
async function apiRequest(url, options = {}) {
    const token = localStorage.getItem('auth_token');
    
    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(token && { 'Authorization': `Bearer ${token}` })
        }
    };

    try {
        const response = await fetch(`/api${url}`, { ...defaultOptions, ...options });
        
        if (!response.ok) {
            if (response.status === 401) {
                // Unauthorized - redirect to login
                window.location.href = '/login';
                return;
            }
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('API request failed:', error);
        showNotification('حدث خطأ في الاتصال', 'error');
        throw error;
    }
}

// Books Management
async function loadBooks() {
    try {
        const params = new URLSearchParams({
            page: currentPage,
            ...(document.getElementById('searchInput')?.value && { search: document.getElementById('searchInput').value }),
            ...(document.getElementById('categoryFilter')?.value && { category_id: document.getElementById('categoryFilter').value }),
            ...(document.getElementById('authorFilter')?.value && { author_id: document.getElementById('authorFilter').value }),
            ...(document.getElementById('statusFilter')?.value && { status: document.getElementById('statusFilter').value })
        });

        const data = await apiRequest(`/books?${params}`);
        displayBooks(data.data);
        displayPagination(data);
    } catch (error) {
        console.error('Failed to load books:', error);
    }
}

function displayBooks(books) {
    const tbody = document.getElementById('booksTableBody');
    if (!tbody) return;

    tbody.innerHTML = '';

    books.forEach(book => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${book.title}</td>
            <td>${book.author?.name || 'غير محدد'}</td>
            <td>${book.category?.name || 'غير محدد'}</td>
            <td>${book.quantity}</td>
            <td>${book.available_quantity}</td>
            <td><span class="book-status ${book.status}">${getStatusText(book.status)}</span></td>
            <td>
                <button onclick="editBook(${book.id})" class="btn-secondary" style="padding: 5px 10px; margin-left: 5px;">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteBook(${book.id})" class="btn-logout" style="padding: 5px 10px;">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function getStatusText(status) {
    const statusMap = {
        'available': 'متاح',
        'borrowed': 'مستعار',
        'maintenance': 'صيانة'
    };
    return statusMap[status] || status;
}

async function loadCategories() {
    try {
        const data = await apiRequest('/categories');
        const select = document.getElementById('categoryFilter');
        const formSelect = document.getElementById('category_id');
        
        if (select) {
            select.innerHTML = '<option value="">جميع التصنيفات</option>';
            data.data.forEach(category => {
                select.innerHTML += `<option value="${category.id}">${category.name}</option>`;
            });
        }
        
        if (formSelect) {
            formSelect.innerHTML = '<option value="">اختر التصنيف</option>';
            data.data.forEach(category => {
                formSelect.innerHTML += `<option value="${category.id}">${category.name}</option>`;
            });
        }
    } catch (error) {
        console.error('Failed to load categories:', error);
    }
}

async function loadAuthors() {
    try {
        const data = await apiRequest('/authors');
        const select = document.getElementById('authorFilter');
        const formSelect = document.getElementById('author_id');
        
        if (select) {
            select.innerHTML = '<option value="">جميع المؤلفين</option>';
            data.data.forEach(author => {
                select.innerHTML += `<option value="${author.id}">${author.name}</option>`;
            });
        }
        
        if (formSelect) {
            formSelect.innerHTML = '<option value="">اختر المؤلف</option>';
            data.data.forEach(author => {
                formSelect.innerHTML += `<option value="${author.id}">${author.name}</option>`;
            });
        }
    } catch (error) {
        console.error('Failed to load authors:', error);
    }
}

// Modal Functions
function openAddBookModal() {
    const modal = document.getElementById('bookModal');
    const modalTitle = document.getElementById('modalTitle');
    const form = document.getElementById('bookForm');
    
    modalTitle.textContent = 'إضافة كتاب جديد';
    form.reset();
    form.dataset.mode = 'create';
    
    modal.style.display = 'block';
}

function closeBookModal() {
    const modal = document.getElementById('bookModal');
    modal.style.display = 'none';
}

async function editBook(bookId) {
    try {
        const book = await apiRequest(`/books/${bookId}`);
        
        const modal = document.getElementById('bookModal');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('bookForm');
        
        modalTitle.textContent = 'تعديل الكتاب';
        form.dataset.mode = 'edit';
        form.dataset.bookId = bookId;
        
        // Fill form fields
        document.getElementById('title').value = book.title;
        document.getElementById('description').value = book.description || '';
        document.getElementById('category_id').value = book.category_id;
        document.getElementById('author_id').value = book.author_id;
        document.getElementById('quantity').value = book.quantity;
        document.getElementById('language').value = book.language;
        
        modal.style.display = 'block';
    } catch (error) {
        console.error('Failed to load book:', error);
        showNotification('فشل في تحميل بيانات الكتاب', 'error');
    }
}

async function handleBookSubmit(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    try {
        if (form.dataset.mode === 'edit') {
            await apiRequest(`/books/${form.dataset.bookId}`, {
                method: 'PUT',
                body: JSON.stringify(data)
            });
            showNotification('تم تحديث الكتاب بنجاح', 'success');
        } else {
            await apiRequest('/books', {
                method: 'POST',
                body: JSON.stringify(data)
            });
            showNotification('تم إضافة الكتاب بنجاح', 'success');
        }
        
        closeBookModal();
        loadBooks();
    } catch (error) {
        console.error('Failed to save book:', error);
        showNotification('فشل في حفظ الكتاب', 'error');
    }
}

async function deleteBook(bookId) {
    if (!confirm('هل أنت متأكد من حذف هذا الكتاب؟')) {
        return;
    }
    
    try {
        await apiRequest(`/books/${bookId}`, {
            method: 'DELETE'
        });
        showNotification('تم حذف الكتاب بنجاح', 'success');
        loadBooks();
    } catch (error) {
        console.error('Failed to delete book:', error);
        showNotification('فشل في حذف الكتاب', 'error');
    }
}

// Pagination
function displayPagination(data) {
    const pagination = document.getElementById('pagination');
    if (!pagination) return;
    
    currentPage = data.current_page;
    totalPages = data.last_page;
    
    let paginationHTML = '';
    
    // Previous button
    if (data.prev_page_url) {
        paginationHTML += `<button onclick="changePage(${currentPage - 1})">السابق</button>`;
    }
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
            paginationHTML += `<button class="active">${i}</button>`;
        } else {
            paginationHTML += `<button onclick="changePage(${i})">${i}</button>`;
        }
    }
    
    // Next button
    if (data.next_page_url) {
        paginationHTML += `<button onclick="changePage(${currentPage + 1})">التالي</button>`;
    }
    
    pagination.innerHTML = paginationHTML;
}

function changePage(page) {
    currentPage = page;
    loadBooks();
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 6px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        ${type === 'success' ? 'background: #27ae60;' : 
          type === 'error' ? 'background: #e74c3c;' : 
          'background: #3498db;'}
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

function logout() {
    localStorage.removeItem('auth_token');
    window.location.href = '/login';
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style); 