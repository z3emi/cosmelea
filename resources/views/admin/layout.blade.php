<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'لوحة تحكم Cosmelea')</title>

    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet" xintegrity="sha384-dpuaG1suU0eT09Tx5utwqxOBSyad/zaRprTacevYkfPBuA/4RbOA4Ry9bFIX/9VI" crossorigin="anonymous">
    
    <!-- Icons and Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f7fa;
        }
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background-color: #1f2937;
            color: #e5e7eb;
            transition: margin-right 0.3s ease-in-out;
        }
        .sidebar .nav-link {
            color: #d1d5db;
            font-size: 1rem;
            padding: 0.9rem 1.25rem;
            border-right: 4px solid transparent;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link .bi {
            margin-left: 0.75rem;
            font-size: 1.2rem;
        }
        .sidebar .nav-link:hover {
            background-color: #374151;
            color: #ffffff;
        }
        .sidebar .nav-link.active {
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: 700;
            border-right-color: #ffffff;
        }
        .sidebar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            background-color: #ffffff;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            padding: 0.75rem 1.5rem;
        }
        
        /* Mobile Specific Styles */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                right: -260px; /* Hidden by default */
                z-index: 1030;
                margin-right: 0 !important;
            }
            .sidebar.is-open {
                right: 0; /* Shown when active */
            }
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 1020;
                display: none;
            }
            .sidebar-overlay.is-open {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column p-3" id="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand text-white text-decoration-none d-flex align-items-center mb-4">
                <i class="bi bi-shield-shaded fs-2 me-2"></i>
                <span>Cosmelea</span>
            </a>
            
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>لوحة التحكم</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>إدارة الأقسام</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>إدارة المنتجات</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt"></i>
                        <span>إدارة الطلبات</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>إدارة العملاء</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>إدارة المستخدمين</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                       <i class="bi bi-shield-lock"></i>
                       <span>الأدوار والصلاحيات</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.expenses.index') }}" class="nav-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
                       <i class="bi bi-wallet2"></i>
                       <span>إدارة المصاريف</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.inventory.index') }}" class="nav-link {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
                       <i class="bi bi-boxes"></i>
                       <span>المخزن</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                       <i class="bi bi-bar-chart-line"></i>
                       <span>التقارير المالية</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <!-- Main Content -->
        <div class="content-wrapper">
            <nav class="topbar d-flex justify-content-between align-items-center">
                 <button class="btn d-lg-none" type="button" id="sidebar-toggle-btn">
                     <i class="bi bi-list fs-3"></i>
                 </button>
                 <div class="ms-auto dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://i.pravatar.cc/40?u={{ Auth::id() }}" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="{{ route('homepage') }}" target="_blank">عرض الموقع</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                تسجيل الخروج
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                 @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <!-- Bootstrap JS Bundle from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            function toggleSidebar() {
                sidebar.classList.toggle('is-open');
                overlay.classList.toggle('is-open');
            }
            if(toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }
            if(overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
