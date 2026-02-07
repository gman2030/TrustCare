<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Panel | TrustCare</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">

    <style>
        :root {
            --primary: #1b2d95;
            --secondary: #e91e63;
            --bg-light: #f8fafc;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            display: flex;
        }

        /* Sidebar Style */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary);
            height: 100vh;
            position: fixed;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* القائمة الموحدة */
        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            flex-grow: 1;
        }

        .sidebar-menu li a, .sidebar-menu li button {
            padding: 15px 25px;
            display: flex;
            align-items: center;
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.3s;
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 16px;
            text-align: left;
        }

        .sidebar-menu li i {
            margin-right: 15px;
            font-size: 18px;
            width: 25px;
            text-align: center;
        }

        /* تنسيق الرابط النشط أو عند التحويم */
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active,
        .sidebar-menu li button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 5px solid var(--secondary);
        }

        /* قسم المحتوى */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            padding: 30px;
        }

        .top-nav {
            background: white;
            padding: 15px 30px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* تنسيق خاص لزر تسجيل الخروج في الأسفل */
        .logout-item {
            margin-top:150%;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-item button {
            color: #f87171 !important;
        }
    </style>
    @yield('styles')
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
                <a href="{{ route('worker.dashboard') }}" class="{{ request()->routeIs('worker.dashboard') ? 'active' : '' }}">
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
