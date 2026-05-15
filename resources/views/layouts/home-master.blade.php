<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel | TrustCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <style>
        /* ── LANGUAGE SWITCHER ── */
        .lang-switcher { position: relative; }

        .lang-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            background: white;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 7px 13px;
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 1px 6px rgba(0,0,0,0.07);
            white-space: nowrap;
        }

        .lang-btn:hover {
            border-color: #1b2d95;
            box-shadow: 0 3px 12px rgba(27,45,149,0.15);
        }

        .lang-btn .chevron {
            font-size: 11px;
            color: #94a3b8;
            transition: transform 0.22s;
        }

        .lang-switcher.open .chevron { transform: rotate(180deg); }

        .lang-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 6px;
            min-width: 160px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.12);
            opacity: 0;
            transform: translateY(-6px) scale(0.97);
            pointer-events: none;
            transition: all 0.2s cubic-bezier(0.34,1.56,0.64,1);
            z-index: 9999;
        }

        .lang-switcher.open .lang-dropdown {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }

        .lang-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: #0f172a;
            transition: background 0.15s;
            user-select: none;
        }

        .lang-option:hover { background: #f1f5f9; }

        .lang-option.active {
            background: #eef2ff;
            color: #1b2d95;
            font-weight: 700;
        }

        .lang-option .lang-name { flex: 1; }

        .lang-option .check {
            font-size: 13px;
            color: #1b2d95;
            opacity: 0;
        }

        .lang-option.active .check { opacity: 1; }

        /* ── RTL SUPPORT ── */
        [dir="rtl"] .sidebar { left: auto; right: 0; }
        [dir="rtl"] .main-content { margin-left: 0; margin-right: 260px; }
        [dir="rtl"] .main-content.expanded { margin-right: 0; }
        [dir="rtl"] .sidebar.hidden { transform: translateX(100%); }
        [dir="rtl"] .lang-dropdown { right: auto; left: 0; }
        [dir="rtl"] .sidebar-menu a,
        [dir="rtl"] .sidebar-menu button { flex-direction: row-reverse; text-align: right; }
        [dir="rtl"] .sidebar-menu i { margin-right: 0; margin-left: 10px; }
        [dir="rtl"] .breadcrumb-nav { flex-direction: row-reverse; }
        [dir="rtl"] * { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- ===================== SIDEBAR ===================== --}}
    <div class="sidebar" id="mainSidebar">
        <div class="sidebar-header">
            <img src="{{ asset('image/logo-icon.png') }}" alt="TrustCare Logo">
            <h3>TrustCare</h3>
            <small id="sb-user-area">User Area</small>
        </div>

        <div class="sidebar-user-info">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=1b2d95&color=fff"
                alt="{{ Auth::user()->name }}">
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role" id="sb-role-label">User</div>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-section-title" id="sb-main-label">Main</li>

            <li>
                <a class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span id="sb-dashboard">Dashboard</span>
                </a>
            </li>

            <li>
                <a class="{{ request()->routeIs('user.invoice') ? 'active' : '' }}" href="{{ route('thebill') }}">
                    <i class="fas fa-file-invoice"></i>
                    <span id="sb-bill">The Bill</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.solutions') }}">
                    <i class="fas fa-lightbulb me-2"></i>
                    <span id="sb-solutions">Proposed solutions</span>
                </a>
            </li>

            <li class="logout-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i>
                        <span id="sb-logout">Logout</span>
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
                    <span id="nav-menu-label">Menu</span>
                </button>
                <div class="breadcrumb-nav">
                    <i class="fas fa-home" style="color: #94a3b8;"></i>
                    <span class="separator">/</span>
                    <strong>@yield('page-title', 'Dashboard')</strong>
                </div>
            </div>

            <div class="top-nav-right">
                {{-- Notification --}}
                <div class="notif-btn">
                    <i class="fas fa-bell" style="font-size: 15px;"></i>
                    <span class="notif-dot"></span>
                </div>

                {{-- Role badge --}}
                <span class="role-badge">
                    <i class="fas fa-user" style="margin-right: 5px; font-size: 10px;"></i>
                    <span id="nav-role-label">User</span>
                </span>

                {{-- ── LANGUAGE SWITCHER ── --}}
                <div class="lang-switcher" id="langSwitcher">
                    <button class="lang-btn" type="button" onclick="toggleLangDropdown(event)">
                        <span id="currentFlag">🇬🇧</span>
                        <span id="currentLangLabel">EN</span>
                        <span class="chevron">▾</span>
                    </button>
                    <div class="lang-dropdown" id="langDropdown">
                        <div class="lang-option active" data-lang="en" onclick="setLang('en')">
                            <span>🇬🇧</span>
                            <span class="lang-name">English</span>
                            <span class="check">✓</span>
                        </div>
                        <div class="lang-option" data-lang="fr" onclick="setLang('fr')">
                            <span>🇫🇷</span>
                            <span class="lang-name">Français</span>
                            <span class="check">✓</span>
                        </div>
                        <div class="lang-option" data-lang="ar" onclick="setLang('ar')">
                            <span>🇩🇿</span>
                            <span class="lang-name">العربية</span>
                            <span class="check">✓</span>
                        </div>
                    </div>
                </div>
                {{-- ── END LANGUAGE SWITCHER ── --}}

                {{-- Avatar --}}
                <div class="top-nav-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=1b2d95&color=fff"
                        alt="{{ Auth::user()->name }}">
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
        /* =========================================
           SIDEBAR TOGGLE
        ========================================= */
        let sidebarOpen = true;

        function toggleSidebar() {
            const sidebar     = document.getElementById('mainSidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay     = document.getElementById('sidebarOverlay');
            const icon        = document.getElementById('menuToggleIcon');

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

        /* =========================================
           TRANSLATIONS
        ========================================= */
        const TC_TRANS = {
            en: {
                dir: 'ltr', lang: 'en', flag: '🇬🇧', short: 'EN',
                'sb-user-area':   'User Area',
                'sb-role-label':  'User',
                'sb-main-label':  'Main',
                'sb-dashboard':   'Dashboard',
                'sb-bill':        'The Bill',
                'sb-solutions':   'Proposed solutions',
                'sb-logout':      'Logout',
                'nav-menu-label': 'Menu',
                'nav-role-label': 'User',
            },
            fr: {
                dir: 'ltr', lang: 'fr', flag: '🇫🇷', short: 'FR',
                'sb-user-area':   'Espace Utilisateur',
                'sb-role-label':  'Utilisateur',
                'sb-main-label':  'Menu principal',
                'sb-dashboard':   'Tableau de bord',
                'sb-bill':        'Ma Facture',
                'sb-solutions':   'Solutions proposées',
                'sb-logout':      'Déconnexion',
                'nav-menu-label': 'Menu',
                'nav-role-label': 'Utilisateur',
            },
            ar: {
                dir: 'rtl', lang: 'ar', flag: '🇩🇿', short: 'AR',
                'sb-user-area':   'منطقة المستخدم',
                'sb-role-label':  'مستخدم',
                'sb-main-label':  'القائمة الرئيسية',
                'sb-dashboard':   'لوحة التحكم',
                'sb-bill':        'الفاتورة',
                'sb-solutions':   'الحلول المقترحة',
                'sb-logout':      'تسجيل الخروج',
                'nav-menu-label': 'القائمة',
                'nav-role-label': 'مستخدم',
            }
        };

        /* IDs to translate (all use textContent) */
        const TC_IDS = [
            'sb-user-area','sb-role-label','sb-main-label',
            'sb-dashboard','sb-bill','sb-solutions','sb-logout',
            'nav-menu-label','nav-role-label'
        ];

        /* ── DROPDOWN TOGGLE ── */
        function toggleLangDropdown(e) {
            e.stopPropagation();
            document.getElementById('langSwitcher').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#langSwitcher')) {
                document.getElementById('langSwitcher').classList.remove('open');
            }
        });

        /* ── SET LANGUAGE ── */
        function setLang(lang) {
            const t = TC_TRANS[lang];
            if (!t) return;

            /* direction */
            const root = document.getElementById('html-root');
            root.setAttribute('dir',  t.dir);
            root.setAttribute('lang', t.lang);

            /* text content */
            TC_IDS.forEach(function(id) {
                const el = document.getElementById(id);
                if (el && t[id]) el.textContent = t[id];
            });

            /* switcher button */
            document.getElementById('currentFlag').textContent      = t.flag;
            document.getElementById('currentLangLabel').textContent = t.short;

            /* active state */
            document.querySelectorAll('.lang-option').forEach(function(opt) {
                opt.classList.toggle('active', opt.dataset.lang === lang);
            });

            /* close & save */
            document.getElementById('langSwitcher').classList.remove('open');
            localStorage.setItem('trustcare_lang', lang);
        }

        /* ── RESTORE ON LOAD ── */
        (function() {
            var saved = localStorage.getItem('trustcare_lang');
            if (saved && TC_TRANS[saved]) setLang(saved);
        })();
    </script>
</body>

</html>