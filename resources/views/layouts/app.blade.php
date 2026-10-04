<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Student Information System')</title>
    <!-- Links to your custom style.css in the public folder -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="app-layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">🎓</div>
            <div>
                <div class="sidebar-brand-name">Student Info<br>System</div>
                <div class="sidebar-brand-sub">Admin Panel</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Dashboard</a>
            <a href="{{ route('students.create') }}" class="nav-item {{ request()->routeIs('students.create') ? 'active' : '' }}">➕ Add Student</a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-chip">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->username ?? 'AD', 0, 2)) }}
                </div>
                <div>
                    <!-- Dynamically displays the logged-in username -->
                    <div class="user-name">{{ Auth::user()->username ?? 'Administrator' }}</div>
                    <div class="user-role">System Admin</div>
                </div>
            </div>
            
            <!-- Secure Laravel Logout Form -->
            <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
                @csrf
                <a href="{{ route('logout') }}" class="logout-link" onclick="event.preventDefault(); this.closest('form').submit();">
                    🚪 Logout
                </a>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <div class="main-content">
        <div class="topbar">
            <span class="topbar-title">@yield('header_title', 'Dashboard')</span>
            @yield('topbar_actions')
        </div>

        <div class="page-content">
            <!-- Global Flash Message -->
            @if (session('flash'))
                <div class="alert alert-success">
                    ✅ {{ session('flash') }}
                </div>
            @endif

            <!-- Page Specific Content Injects Here -->
            @yield('content')
        </div>
    </div>

</body>
</html>