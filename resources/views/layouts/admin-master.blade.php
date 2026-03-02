<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <aside class="sidebar">
        {{-- Professional Logo Area --}}
        <div class="sidebar-header">
            <div class="logo-wrapper">
                <img src="{{ asset('image/logo-icon.png') }}" alt="TrustCare Logo">
            </div>
            <h3 class="brand-name">TrustCare <span class="admin-badge">Admin</span></h3>
        </div>



        {{-- Navigation Menu --}}
        <nav class="sidebar-menu" style="margin-top: 20px; display: flex; flex-direction: column;">

            <li class="nav-item">
                <a href="{{ route('admin.home') }}"
                    style="display: flex; align-items: center; padding: 15px 25px; color: {{ request()->routeIs('admin.home') ? '#e91e63' : 'rgba(255,255,255,0.7)' }}; text-decoration: none; background: {{ request()->routeIs('admin.home') ? 'rgba(255,255,255,0.05)' : 'transparent' }}; border-left: {{ request()->routeIs('admin.home') ? '4px solid #e91e63' : 'none' }}; transition: 0.3s;">
                    <i class="fas fa-th-large" style="margin-right: 15px; width: 20px;"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.workers') }}"
                    style="display: flex; align-items: center; padding: 15px 25px; color: {{ request()->routeIs('admin.workers') ? '#e91e63' : 'rgba(255,255,255,0.7)' }}; text-decoration: none; background: {{ request()->routeIs('admin.workers') ? 'rgba(255,255,255,0.05)' : 'transparent' }}; border-left: {{ request()->routeIs('admin.workers') ? '4px solid #e91e63' : 'none' }}; transition: 0.3s;">
                    <i class="fas fa-users-cog" style="margin-right: 15px; width: 20px;"></i>
                    <span>Workers Control</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}"
                    class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span class="menu-title">Spare parts requests</span>

                    @if (isset($newOrdersCount) && $newOrdersCount > 0)
                        <span class="badge-count">{{ $newOrdersCount }}</span>
                    @endif
                </a>
            </li>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            {{-- Admin Profile Section --}}
            <div class="admin-profile">
                <div class="admin-info">
                    <div class="admin-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="admin-details">
                        <span class="admin-name">{{ Auth::user()->name }}</span>
                        <span class="admin-status"><i class="fas fa-circle"></i> Online</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>

        </nav>
    </aside>

    <div class="main-content">
        @yield('content')
    </div>
</body>

</html>
