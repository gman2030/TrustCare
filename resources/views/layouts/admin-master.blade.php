<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | TrustCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    {{-- Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- ===================== SIDEBAR ===================== --}}
    <div class="sidebar" id="mainSidebar">

        <div class="sidebar-header">
            <img src="{{ asset('image/logo-icon.png') }}" alt="TrustCare Logo">
            <h3>TrustCare <span class="admin-tag">Admin</span></h3>
        </div>

        {{-- Admin user info --}}
        <div class="sidebar-user-info">
            <div class="admin-avatar-circle">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">
                    <i class="fas fa-circle"></i> Online
                </div>
            </div>
        </div>

        <ul class="sidebar-menu">

            <li class="menu-section-title">Management</li>

            <li>
                <a href="{{ route('admin.home') }}"
                    class="{{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Home</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.workers') }}"
                    class="{{ request()->routeIs('admin.workers') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i>
                    <span>Workers Control</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.orders.index') }}"
                    class="{{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                    <i class="fas fa-tools"></i>
                    <span>Spare Parts Requests</span>
                    @php $count = Auth::user()->unreadNotifications->count(); @endphp
                    @if ($count > 0)
                        <span class="menu-notif-badge">{{ $count }}</span>
                    @endif
                </a>
            </li>

            <li class="logout-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <div class="main-content" id="mainContent">

        {{-- Top Navigation Bar --}}
        <div class="top-nav">
            <div class="top-nav-left">
                <button class="menu-toggle-btn" onclick="toggleSidebar()" id="menuToggleBtn">
                    <i class="fas fa-bars" id="menuToggleIcon"></i>
                    Menu
                </button>
                <div class="breadcrumb-nav">
                    <i class="fas fa-home" style="color: #94a3b8;"></i>
                    <span class="separator">/</span>
                    <strong>@yield('page-title', 'Dashboard')</strong>
                </div>
            </div>

            <div class="top-nav-right">

                {{-- Notifications bell with count --}}
                @php $notifCount = Auth::user()->unreadNotifications->count(); @endphp
                <a href="{{ route('admin.orders.index') }}" class="notif-btn">
                    <i class="fas fa-bell" style="font-size: 15px;"></i>
                    @if($notifCount > 0)
                        <span class="notif-count">{{ $notifCount }}</span>
                    @endif
                </a>

                {{-- Role badge --}}
                <span class="role-badge">
                    <i class="fas fa-shield-alt" style="margin-right: 5px; font-size: 10px;"></i>
                    Administrator
                </span>

                {{-- Avatar with initial --}}
                <div class="top-nav-avatar">
                    <div class="avatar-circle">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span>{{ Auth::user()->name }}</span>
                </div>

            </div>
        </div>

        {{-- Page Content --}}
        <div class="content-area">
            @yield('content')
        </div>

    </div>

    @yield('scripts')

    <script>
        let sidebarOpen = true;

        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('sidebarOverlay');
            const icon = document.getElementById('menuToggleIcon');

            sidebarOpen = !sidebarOpen;

            if (sidebarOpen) {
                sidebar.classList.remove('hidden');
                mainContent.classList.remove('expanded');
                overlay.classList.remove('visible');
                icon.style.transform = 'rotate(0deg)';
            } else {
                sidebar.classList.add('hidden');
                mainContent.classList.add('expanded');
                overlay.classList.add('visible');
                icon.style.transform = 'rotate(90deg)';
            }
        }
    </script>

</body>

</html>
