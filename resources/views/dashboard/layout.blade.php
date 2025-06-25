<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Library</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --bs-body-font-family: 'Cairo', sans-serif;
        }
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 1rem;
            transition: margin 0.3s ease-in-out;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }
        .sidebar .nav-link .fa-fw {
            margin-right: 0.5rem;
        }
        .main-content {
            margin-left: 280px;
            padding: 1.5rem;
            transition: margin 0.3s ease-in-out;
        }

        [dir="rtl"] .main-content {
            margin-left: 0;
            margin-right: 280px;
        }
        [dir="rtl"] .sidebar .nav-link .fa-fw {
            margin-right: 0;
            margin-left: 0.5rem;
        }
        
        /* Collapsed State */
        body.sidebar-collapsed .sidebar {
            margin-left: -280px;
        }
        body.sidebar-collapsed .main-content {
            margin-left: 0;
            width: 100%;
        }

        [dir="rtl"] body.sidebar-collapsed .sidebar {
            margin-left: 0;
            margin-right: -280px;
        }
        [dir="rtl"] body.sidebar-collapsed .main-content {
            margin-right: 0;
            margin-left: 0;
            width: 100%;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        @include('dashboard.partials.sidebar')
        
        <div class="main-content flex-grow-1">
            @include('dashboard.partials.header')
            
            <main class="mt-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        if (sidebarToggle) {
            // Restore sidebar state from localStorage
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.body.classList.add('sidebar-collapsed');
            }

            sidebarToggle.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-collapsed');
                // Save sidebar state to localStorage
                localStorage.setItem('sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
            });
        }
    });
    </script>
    @stack('scripts')
</body>
</html> 