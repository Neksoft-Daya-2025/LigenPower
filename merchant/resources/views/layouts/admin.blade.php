<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Ligen Dealer Locator')</title>
    <link rel="icon" type="image/webp" href="{{ asset('cropped-ligen1.png.webp') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #82ac3a;
            --dark-green: #6b8a2e;
            --primary-blue: #6c757d;
            --dark-blue: #495057;
            --sidebar-width: 260px;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; margin: 0; }
        .admin-wrapper { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #343a40 0%, #212529 100%);
            color: white;
            flex-shrink: 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        .admin-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-sidebar-header a { color: white; text-decoration: none; font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; gap: 10px; }
        .admin-sidebar-header a:hover { color: var(--primary-green); }
        .admin-sidebar-nav { padding: 16px 0; }
        .admin-sidebar-nav .nav-section { margin-bottom: 8px; }
        .admin-sidebar-nav .nav-section-title {
            padding: 8px 20px;
            font-size: 11px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.5px;
        }
        .admin-sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .admin-sidebar-nav .nav-link:hover { background: rgba(255,255,255,0.08); color: white; }
        .admin-sidebar-nav .nav-link.active { background: rgba(130,172,58,0.2); color: var(--primary-green); border-left-color: var(--primary-green); }
        .admin-sidebar-nav .nav-link i { width: 20px; text-align: center; opacity: 0.9; }
        .admin-main { flex: 1; margin-left: var(--sidebar-width); padding: 24px; min-height: 100vh; }
        .admin-topbar {
            background: white;
            padding: 12px 24px;
            margin: -24px -24px 24px -24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-topbar .user-info { font-size: 14px; color: #6c757d; }
        .admin-topbar .user-info strong { color: #212529; }
        @media (max-width: 991px) {
            .admin-sidebar { transform: translateX(-100%); width: 280px; }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .sidebar-toggle { display: block !important; }
        }
        .sidebar-toggle { display: none; position: fixed; bottom: 20px; left: 20px; z-index: 1001; }
        .btn-primary { background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue)); border: none; }
        .btn-success { background: linear-gradient(135deg, var(--primary-green), var(--dark-green)); border: none; }
        .card { border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-radius: 12px; }
        .table th { background-color: var(--primary-blue); color: white; border: none; }
    </style>
    @yield('styles')
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-store"></i>
                    <span>Ligen Admin</span>
                </a>
            </div>
            <nav class="admin-sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Dealers</div>
                    <a href="{{ route('admin.create') }}" class="nav-link {{ request()->routeIs('admin.create') ? 'active' : '' }}">
                        <i class="fas fa-plus"></i> Add Dealer
                    </a>
                    <a href="{{ route('admin.import') }}" class="nav-link {{ request()->routeIs('admin.import') ? 'active' : '' }}">
                        <i class="fas fa-file-import"></i> Import CSV
                    </a>
                    <a href="{{ route('admin.export') }}" class="nav-link">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Locations</div>
                    <a href="{{ route('admin.states.index') }}" class="nav-link {{ request()->routeIs('admin.states.*') ? 'active' : '' }}">
                        <i class="fas fa-map"></i> States
                    </a>
                    <a href="{{ route('admin.districts.index') }}" class="nav-link {{ request()->routeIs('admin.districts.*') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt"></i> Districts
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Account</div>
                    <a href="https://ligenpower.com/" target="_blank" class="nav-link">
                        <i class="fas fa-external-link-alt"></i> Main Website
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent" style="cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>
        <main class="admin-main">
            <div class="admin-topbar">
                <div>
                    <span class="user-info">Welcome, <strong>{{ optional(Auth::guard('admin')->user())->name ?? 'Admin' }}</strong></span>
                </div>
                <button class="btn btn-outline-secondary btn-sm sidebar-toggle" type="button" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
                    <i class="fas fa-bars"></i> Menu
                </button>
            </div>
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
