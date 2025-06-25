// إشعار بسيط عند التبديل بين اللغات
const langBtn = document.querySelector('.lang-btn');
if (langBtn) {
    langBtn.addEventListener('click', function() {
        alert('سيتم تبديل اللغة بعد إعادة تحميل الصفحة.');
    });
}

// User Dropdown Toggle
window.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.querySelector('.user-dropdown');
    if (dropdown) {
        var toggle = dropdown.querySelector('.user-dropdown-toggle');
        var menu = dropdown.querySelector('.user-dropdown-menu');
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    }
});

// Future: Add more JS enhancements here 

document.addEventListener('DOMContentLoaded', function () {

    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            const layout = document.querySelector('.app-container');
            layout.classList.toggle('sidebar-collapsed');
            
            // Save the state in a cookie
            const isCollapsed = layout.classList.contains('sidebar-collapsed');
            document.cookie = `sidebar-collapsed=${isCollapsed};path=/;max-age=31536000`; // Expires in 1 year
        });
    }

    // Language Tabs
    const langTabs = document.querySelectorAll('.lang-tabs .tab-link');
    langTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.dataset.target;
            
            // Deactivate all tabs and content in the same container
            const parent = this.closest('.form-card');
            parent.querySelectorAll('.lang-tabs .tab-link').forEach(t => t.classList.remove('active'));
            parent.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            // Activate the clicked tab and its content
            this.classList.add('active');
            document.getElementById(targetId).classList.add('active');
        });
    });

    // Handle user dropdown toggle
    const userDropdown = document.querySelector('.user-dropdown');
    if (userDropdown) {
        var toggle = userDropdown.querySelector('.user-dropdown-toggle');
        var menu = userDropdown.querySelector('.user-dropdown-menu');
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('open');
        });
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target)) {
                userDropdown.classList.remove('open');
            }
        });
    }
}); 