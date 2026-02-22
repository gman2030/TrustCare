<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Panel | TrustCare</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/worker.css') }}">
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('image/logo-icon.png') }}" style="height: 50px;">
            <h3 style="margin-top: 10px; letter-spacing: 1px;">TrustCare</h3>
            <small style="color: #94a3b8; font-weight: bold;">WORKER AREA</small>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('worker.dashboard') }}"
                    class="{{ request()->routeIs('worker.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span>My Tasks</span>
                </a>
            </li>

            <li>
                <a href="{{ route('worker.spare') }}" class="{{ request()->routeIs('worker.spare') ? 'active' : '' }}">
                    <i class="fas fa-tools"></i>
                    <span>Spare Parts Inventory</span>
                </a>
            </li>

            <li class="logout-item">
                <form action="{{ route('logout') }}" method="POST" id="logout-form-sidebar">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-nav">
            <div>
                <span style="color: #64748b;">Role: <strong>Maintenance Technician</strong></span>
            </div>
            <div style="display: flex; align-items: center; gap: 20px;">
                <span style="font-weight: 600;">{{ Auth::user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=1b2d95&color=fff"
                    style="height: 35px; border-radius: 50%;">
            </div>
        </div>

        @yield('content')
    </div>

    @yield('scripts')
</body>

</html>
