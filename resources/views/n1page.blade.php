<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrustCare</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/n1page.css') }}">

    <style>
        /* ─── LANGUAGE SWITCHER ─── */
        .lang-switcher {
            position: relative;
        }

        .lang-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .lang-btn:hover {
            border-color: var(--accent-color);
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.18);
        }

        .lang-btn .flag {
            font-size: 18px;
            line-height: 1;
        }

        .lang-btn .chevron {
            font-size: 18px;
            color: #94a3b8;
            transition: transform 0.25s ease;
        }

        .lang-switcher.open .chevron {
            transform: rotate(180deg);
        }

        .lang-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 8px;
            min-width: 185px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
            opacity: 0;
            transform: translateY(-10px) scale(0.97);
            pointer-events: none;
            transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
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
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.15s;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            user-select: none;
        }

        .lang-option:hover {
            background: #f1f5f9;
        }

        .lang-option.active {
            background: #eff6ff;
            color: var(--accent-color);
            font-weight: 700;
        }

        .lang-option .flag {
            font-size: 20px;
            line-height: 1;
        }

        .lang-option .lang-name {
            flex: 1;
        }

        .lang-option .check {
            font-size: 17px;
            color: var(--accent-color);
            opacity: 0;
            transition: opacity 0.15s;
        }

        .lang-option.active .check {
            opacity: 1;
        }

        /* ─── RTL SUPPORT ─── */
        [dir="rtl"] .lang-dropdown {
            right: auto;
            left: 0;
        }

        [dir="rtl"] .navbar-custom .ms-auto {
            margin-right: auto !important;
            margin-left: 0 !important;
        }

        [dir="rtl"] .hero-title,
        [dir="rtl"] .lead,
        [dir="rtl"] .feature-card h4,
        [dir="rtl"] .feature-card p,
        [dir="rtl"] footer h3,
        [dir="rtl"] footer p {
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            text-align: right;
        }

        [dir="rtl"] .d-flex.align-items-center.gap-4 {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .floating-stats {
            left: auto;
            right: -20px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Trust<span>Care</span></a>
            <div class="ms-auto d-flex align-items-center gap-3">

                <!-- ─── LANGUAGE SWITCHER ─── -->
                <div class="lang-switcher" id="langSwitcher">
                    <button class="lang-btn" onclick="toggleLangDropdown(event)">
                        <span class="flag" id="currentFlag">🇬🇧</span>
                        <span id="currentLangLabel">English</span>
                        <span class="material-symbols-outlined chevron">expand_more</span>
                    </button>

                    <div class="lang-dropdown" id="langDropdown">
                        <div class="lang-option active" data-lang="en" onclick="setLang('en')">
                            <span class="flag">🇬🇧</span>
                            <span class="lang-name">English</span>
                            <span class="material-symbols-outlined check">check_circle</span>
                        </div>
                        <div class="lang-option" data-lang="fr" onclick="setLang('fr')">
                            <span class="flag">🇫🇷</span>
                            <span class="lang-name">Français</span>
                            <span class="material-symbols-outlined check">check_circle</span>
                        </div>
                        <div class="lang-option" data-lang="ar" onclick="setLang('ar')">
                            <span class="flag">🇩🇿</span>
                            <span class="lang-name">العربية</span>
                            <span class="material-symbols-outlined check">check_circle</span>
                        </div>
                    </div>
                </div>
                <!-- ─── END LANGUAGE SWITCHER ─── -->

                <a href="{{ route('login.view') }}" class="btn-main" id="nav-login">Login</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 fade-up">
                    <h1 class="hero-title" id="hero-title">Get peace of mind with <span>TrustCare.</span></h1>
                    <p class="lead text-muted mb-5" id="hero-desc">
                        A unified platform for providing after-sales services and assisting our customers,
                        all in one sleek interface.
                    </p>
                    <div class="d-flex align-items-center gap-4">
                        <a href="{{ route('login.view') }}" class="btn-main" id="hero-cta">Get Started</a>
                        <a href="#" class="btn-ghost">
                            <span class="material-symbols-outlined">play_circle</span>
                            <span id="hero-watch">Watch the video</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 position-relative fade-up" style="animation-delay: 0.2s;">
                    <div class="hero-image-container">
                        <div class="floating-stats" style="top: 15%; left: -20px;">
                            <span class="material-symbols-outlined text-success">verified</span>
                            <div>
                                <h6 class="m-0 fw-bold" id="stat-title">100% Accuracy</h6>
                                <small class="text-muted" id="stat-sub">Real-time tracking</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features-section">
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <h2 class="fw-800 mb-3" style="font-size: 2.5rem;" id="feat-title">Why Choose Our System?</h2>
                <p class="text-muted" id="feat-sub">Engineered for businesses that demand efficiency and speed.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 fade-up" style="animation-delay: 0.1s;">
                    <div class="feature-card">
                        <div class="icon-box" style="background: #f0f9ff; color: #0369a1;">
                            <span class="material-symbols-outlined">home</span>
                        </div>
                        <h4 class="fw-bold" id="f1-title">Field Service</h4>
                        <p class="text-muted" id="f1-desc">Forget the hassle of transporting bulky or sensitive products.
                            Through our platform, you can request certified technicians to visit your location.
                            We bring the tools and expertise to your doorstep.</p>
                    </div>
                </div>

                <div class="col-md-4 fade-up" style="animation-delay: 0.2s;">
                    <div class="feature-card">
                        <div class="icon-box" style="background: #f0fdf4; color: #16a34a;">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <h4 class="fw-bold" id="f2-title">Transparency & Trust</h4>
                        <p class="text-muted" id="f2-desc">We eliminate concerns about "hidden costs." We provide price lists for spare parts
                            and repair costs via downloadable invoices, ensuring fair transactions and long-term relationships.</p>
                    </div>
                </div>

                <div class="col-md-4 fade-up" style="animation-delay: 0.3s;">
                    <div class="feature-card">
                        <div class="icon-box" style="background: #fff1f2; color: #e11d48;">
                            <span class="material-symbols-outlined">encrypted</span>
                        </div>
                        <h4 class="fw-bold" id="f3-title">Enterprise Security</h4>
                        <p class="text-muted" id="f3-desc">Advanced permissions system ensures only the right people access sensitive
                            data, keeping your warranty information safe.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 bg-dark text-white text-center">
        <div class="container">
            <h3 class="fw-bold mb-4" id="footer-cta">Ready to organize your assets?</h3>
            <a href="{{ route('login.view') }}" class="btn-main" id="footer-btn">Start Now for Free</a>
            <hr class="my-5 opacity-25">
            <p class="m-0 opacity-50" id="footer-copy">© TrustCare. TrustCare – Trust us with the warranty on your devices.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ─────────────────────────────────────────────
        //  TRANSLATIONS
        // ─────────────────────────────────────────────
        const translations = {
            en: {
                dir: "ltr",
                lang: "en",
                flag: "🇬🇧",
                label: "English",
                "nav-login":    "Login",
                "hero-title":   "Get peace of mind with <span>TrustCare.</span>",
                "hero-desc":    "A unified platform for providing after-sales services and assisting our customers, all in one sleek interface.",
                "hero-cta":     "Get Started",
                "hero-watch":   "Watch the video",
                "stat-title":   "100% Accuracy",
                "stat-sub":     "Real-time tracking",
                "feat-title":   "Why Choose Our System?",
                "feat-sub":     "Engineered for businesses that demand efficiency and speed.",
                "f1-title":     "Field Service",
                "f1-desc":      "Forget the hassle of transporting bulky or sensitive products. Through our platform, you can request certified technicians to visit your location. We bring the tools and expertise to your doorstep.",
                "f2-title":     "Transparency & Trust",
                "f2-desc":      "We eliminate concerns about \"hidden costs.\" We provide price lists for spare parts and repair costs via downloadable invoices, ensuring fair transactions and long-term relationships.",
                "f3-title":     "Enterprise Security",
                "f3-desc":      "Advanced permissions system ensures only the right people access sensitive data, keeping your warranty information safe.",
                "footer-cta":   "Ready to organize your assets?",
                "footer-btn":   "Start Now for Free",
                "footer-copy":  "© TrustCare – Trust us with the warranty on your devices."
            },
            fr: {
                dir: "ltr",
                lang: "fr",
                flag: "🇫🇷",
                label: "Français",
                "nav-login":    "Connexion",
                "hero-title":   "La tranquillité d'esprit avec <span>TrustCare.</span>",
                "hero-desc":    "Une plateforme unifiée pour fournir des services après-vente et accompagner nos clients, dans une interface moderne et intuitive.",
                "hero-cta":     "Commencer",
                "hero-watch":   "Voir la vidéo",
                "stat-title":   "100% de Précision",
                "stat-sub":     "Suivi en temps réel",
                "feat-title":   "Pourquoi choisir notre système ?",
                "feat-sub":     "Conçu pour les entreprises qui exigent efficacité et rapidité.",
                "f1-title":     "Service sur site",
                "f1-desc":      "Oubliez le transport de vos appareils encombrants. Via notre plateforme, des techniciens certifiés se déplacent directement chez vous avec les outils nécessaires.",
                "f2-title":     "Transparence & Confiance",
                "f2-desc":      "Nous éliminons les coûts cachés en vous fournissant des listes de prix détaillées pour les pièces détachées et les réparations, via des factures téléchargeables.",
                "f3-title":     "Sécurité Entreprise",
                "f3-desc":      "Un système de permissions avancé garantit que seules les bonnes personnes accèdent aux données sensibles, protégeant vos informations de garantie.",
                "footer-cta":   "Prêt à organiser vos actifs ?",
                "footer-btn":   "Commencer gratuitement",
                "footer-copy":  "© TrustCare – Faites-nous confiance pour la garantie de vos appareils."
            },
            ar: {
                dir: "rtl",
                lang: "ar",
                flag: "🇩🇿",
                label: "العربية",
                "nav-login":    "تسجيل الدخول",
                "hero-title":   "راحة البال مع <span>TrustCare.</span>",
                "hero-desc":    "منصة موحدة لتقديم خدمات ما بعد البيع ودعم عملائنا، كل ذلك في واجهة أنيقة وسهلة الاستخدام.",
                "hero-cta":     "ابدأ الآن",
                "hero-watch":   "شاهد الفيديو",
                "stat-title":   "دقة 100%",
                "stat-sub":     "تتبع في الوقت الفعلي",
                "feat-title":   "لماذا تختار نظامنا؟",
                "feat-sub":     "مُصمَّم للشركات التي تتطلب الكفاءة والسرعة.",
                "f1-title":     "خدمة ميدانية",
                "f1-desc":      "تخلص من عناء نقل أجهزتك الكبيرة أو الحساسة. عبر منصتنا، يمكنك طلب تقنيين معتمدين لزيارة موقعك مباشرةً بكل الأدوات والخبرات اللازمة.",
                "f2-title":     "الشفافية والثقة",
                "f2-desc":      "نُزيل القلق من التكاليف الخفية بتوفير قوائم أسعار تفصيلية لقطع الغيار وتكاليف الإصلاح، عبر فواتير قابلة للتحميل لضمان معاملات عادلة.",
                "f3-title":     "أمان المؤسسات",
                "f3-desc":      "نظام صلاحيات متقدم يضمن أن الأشخاص المناسبين فقط يصلون إلى البيانات الحساسة، مع الحفاظ على سلامة معلومات الضمان الخاصة بك.",
                "footer-cta":   "هل أنت مستعد لتنظيم أصولك؟",
                "footer-btn":   "ابدأ مجانًا الآن",
                "footer-copy":  "© TrustCare – ثق بنا في ضمان أجهزتك."
            }
        };

        // ─────────────────────────────────────────────
        //  IDs that use innerHTML (contain HTML tags)
        // ─────────────────────────────────────────────
        const htmlKeys = ["hero-title"];

        // ─────────────────────────────────────────────
        //  TOGGLE DROPDOWN
        // ─────────────────────────────────────────────
        function toggleLangDropdown(e) {
            e.stopPropagation();
            document.getElementById('langSwitcher').classList.toggle('open');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#langSwitcher')) {
                document.getElementById('langSwitcher').classList.remove('open');
            }
        });

        // ─────────────────────────────────────────────
        //  SET LANGUAGE
        // ─────────────────────────────────────────────
        function setLang(lang) {
            const t = translations[lang];
            if (!t) return;

            const root = document.getElementById('html-root');

            // 1. Direction & lang attribute
            root.setAttribute('dir', t.dir);
            root.setAttribute('lang', t.lang);

            // 2. Update all translated elements
            Object.keys(t).forEach(function (key) {
                if (['dir', 'lang', 'flag', 'label'].includes(key)) return;

                const el = document.getElementById(key);
                if (!el) return;

                if (htmlKeys.includes(key)) {
                    el.innerHTML = t[key];
                } else {
                    el.textContent = t[key];
                }
            });

            // 3. Update switcher button display
            document.getElementById('currentFlag').textContent  = t.flag;
            document.getElementById('currentLangLabel').textContent = t.label;

            // 4. Update active state on options
            document.querySelectorAll('.lang-option').forEach(function (opt) {
                opt.classList.toggle('active', opt.dataset.lang === lang);
            });

            // 5. Close dropdown
            document.getElementById('langSwitcher').classList.remove('open');

            // 6. Save preference in localStorage
            localStorage.setItem('trustcare_lang', lang);
        }

        // ─────────────────────────────────────────────
        //  RESTORE SAVED LANGUAGE ON PAGE LOAD
        // ─────────────────────────────────────────────
        (function () {
            const saved = localStorage.getItem('trustcare_lang');
            if (saved && translations[saved]) {
                setLang(saved);
            }
        })();
    </script>

</body>
</html>