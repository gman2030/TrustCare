<!-- resources/views/login-sign up.blade.php -->
<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrustCare</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        /* ─── LANGUAGE SWITCHER ─── */
        .lang-switcher-wrap {
            position: fixed;
            top: 20px;
            right: 24px;
            z-index: 9999;
        }

        .lang-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 9px 15px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 13px;
            color: #0f172a;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }

        .lang-btn:hover {
            border-color: #1b2d95;
            box-shadow: 0 4px 16px rgba(27, 45, 149, 0.18);
        }

        .lang-btn .flag { font-size: 17px; line-height: 1; }

        .lang-btn .chevron {
            font-size: 14px;
            color: #94a3b8;
            transition: transform 0.25s ease;
            font-style: normal;
        }

        .lang-switcher.open .chevron { transform: rotate(180deg); }

        .lang-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 7px;
            min-width: 175px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.13);
            opacity: 0;
            transform: translateY(-8px) scale(0.97);
            pointer-events: none;
            transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .lang-switcher.open .lang-dropdown {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }

        .lang-option {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 13px;
            border-radius: 9px;
            cursor: pointer;
            transition: background 0.15s;
            font-size: 13px;
            font-weight: 500;
            color: #0f172a;
            user-select: none;
        }

        .lang-option:hover { background: #f1f5f9; }

        .lang-option.active {
            background: #eef2ff;
            color: #1b2d95;
            font-weight: 700;
        }

        .lang-option .flag { font-size: 19px; line-height: 1; }
        .lang-option .lang-name { flex: 1; }

        .lang-option .check {
            font-size: 15px;
            color: #1b2d95;
            opacity: 0;
            font-style: normal;
        }
        .lang-option.active .check { opacity: 1; }

        /* ─── RTL SUPPORT ─── */
        [dir="rtl"] .lang-switcher-wrap {
            right: auto;
            left: 24px;
        }

        [dir="rtl"] .lang-dropdown {
            right: auto;
            left: 0;
        }

        [dir="rtl"] .input-box input {
            padding-left: 0;
            padding-right: 35px;
            text-align: right;
        }

        [dir="rtl"] .input-box i {
            left: auto;
            right: 5px;
        }

        [dir="rtl"] .title::after {
            margin-right: 0;
        }

        [dir="rtl"] * {
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
        }
    </style>
</head>
<body>

    <!-- ─── LANGUAGE SWITCHER ─── -->
    <div class="lang-switcher-wrap">
        <div class="lang-switcher" id="langSwitcher">
            <button class="lang-btn" onclick="toggleLangDropdown(event)">
                <span class="flag" id="currentFlag">🇬🇧</span>
                <span id="currentLangLabel">English</span>
                <span class="chevron">▾</span>
            </button>

            <div class="lang-dropdown" id="langDropdown">
                <div class="lang-option active" data-lang="en" onclick="setLang('en')">
                    <span class="flag">🇬🇧</span>
                    <span class="lang-name">English</span>
                    <span class="check">✓</span>
                </div>
                <div class="lang-option" data-lang="fr" onclick="setLang('fr')">
                    <span class="flag">🇫🇷</span>
                    <span class="lang-name">Français</span>
                    <span class="check">✓</span>
                </div>
                <div class="lang-option" data-lang="ar" onclick="setLang('ar')">
                    <span class="flag">🇩🇿</span>
                    <span class="lang-name">العربية</span>
                    <span class="check">✓</span>
                </div>
            </div>
        </div>
    </div>
    <!-- ─── END LANGUAGE SWITCHER ─── -->

    <div class="container">
        <input type="checkbox" id="flip">

        <div class="cover">
            <div class="front">
                <img src="image/login page.PNG" alt="">
                <div class="text">
                    <span class="text-1" id="cover-text-1">Trust us with the warranty on your devices</span><br>
                    <span class="text-2" id="cover-text-2">If you do not have an account, create one now</span>
                </div>
            </div>
            <div class="back">
                <img class="backImg" src="image/sing up page2.jpg" alt="">
                <div class="text">
                    <span class="text-3" id="cover-text-3">Trust us with the warranty on your devices</span><br>
                    <span class="text-4" id="cover-text-4">Create an account now and join our community</span>
                </div>
            </div>
        </div>

        <div class="form-container">

            <!-- LOGIN FORM -->
            <div class="login-form">
                <div class="title" id="login-title">Login</div>

                @if ($errors->any())
                    <div class="text login-text" style="color:red; text-align:center;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="input-boxes">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" id="login-email-input"
                                placeholder="Enter your email" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="login-password-input"
                                placeholder="Enter your password" required>
                        </div>
                        <div class="button input-box">
                            <input type="submit" id="login-btn" value="Login">
                        </div>
                    </form>
                    <div class="text sign-up-text">
                        <span id="no-account-text">Don't have an account?</span>
                        <label for="flip" id="signup-link">Sign up now</label>
                    </div>
                </div>
            </div>

            <!-- SIGN UP FORM -->
            <div class="signup-form">
                <div class="title" id="signup-title">Sign up</div>

                @if(session('success'))
                    <div class="text sign-up-text" style="color:green; text-align:center;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="input-boxes">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" id="signup-name-input"
                                placeholder="Enter your username" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" id="signup-email-input"
                                placeholder="Enter your email" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-phone"></i>
                            <input type="tel" name="phone" id="signup-phone-input"
                                placeholder="Phone number 213" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="signup-password-input"
                                placeholder="Enter your password" required>
                        </div>
                        <div class="button input-box">
                            <input type="submit" id="signup-btn" value="Sign up">
                        </div>
                    </form>
                    <div class="text sign-up-text">
                        <span id="have-account-text">Already have an account?</span>
                        <label for="flip" id="login-link">Login now</label>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        
        const translations = {
            en: {
                dir: "ltr", lang: "en", flag: "🇬🇧", label: "English",
                "cover-text-1":          "Trust us with the warranty on your devices",
                "cover-text-2":          "If you do not have an account, create one now",
                "cover-text-3":          "Trust us with the warranty on your devices",
                "cover-text-4":          "Create an account now and join our community",
                "login-title":           "Login",
                "login-email-input":     "Enter your email",
                "login-password-input":  "Enter your password",
                "login-btn":             "Login",
                "no-account-text":       "Don't have an account?",
                "signup-link":           "Sign up now",
                "signup-title":          "Sign up",
                "signup-name-input":     "Enter your username",
                "signup-email-input":    "Enter your email",
                "signup-phone-input":    "Phone number 213",
                "signup-password-input": "Enter your password",
                "signup-btn":            "Sign up",
                "have-account-text":     "Already have an account?",
                "login-link":            "Login now"
            },
            fr: {
                dir: "ltr", lang: "fr", flag: "🇫🇷", label: "Français",
                "cover-text-1":          "Faites-nous confiance pour la garantie de vos appareils",
                "cover-text-2":          "Si vous n'avez pas de compte, créez-en un maintenant",
                "cover-text-3":          "Faites-nous confiance pour la garantie de vos appareils",
                "cover-text-4":          "Créez un compte maintenant et rejoignez notre communauté",
                "login-title":           "Connexion",
                "login-email-input":     "Entrez votre e-mail",
                "login-password-input":  "Entrez votre mot de passe",
                "login-btn":             "Se connecter",
                "no-account-text":       "Vous n'avez pas de compte ?",
                "signup-link":           "Inscrivez-vous",
                "signup-title":          "Inscription",
                "signup-name-input":     "Entrez votre nom d'utilisateur",
                "signup-email-input":    "Entrez votre e-mail",
                "signup-phone-input":    "Numéro de téléphone 213",
                "signup-password-input": "Entrez votre mot de passe",
                "signup-btn":            "S'inscrire",
                "have-account-text":     "Vous avez déjà un compte ?",
                "login-link":            "Connectez-vous"
            },
            ar: {
                dir: "rtl", lang: "ar", flag: "🇩🇿", label: "العربية",
                "cover-text-1":          "ثق بنا في ضمان أجهزتك",
                "cover-text-2":          "إذا لم يكن لديك حساب، أنشئ واحدًا الآن",
                "cover-text-3":          "ثق بنا في ضمان أجهزتك",
                "cover-text-4":          "أنشئ حسابًا الآن وانضم إلى مجتمعنا",
                "login-title":           "تسجيل الدخول",
                "login-email-input":     "أدخل بريدك الإلكتروني",
                "login-password-input":  "أدخل كلمة المرور",
                "login-btn":             "دخول",
                "no-account-text":       "ليس لديك حساب؟",
                "signup-link":           "سجّل الآن",
                "signup-title":          "إنشاء حساب",
                "signup-name-input":     "أدخل اسم المستخدم",
                "signup-email-input":    "أدخل بريدك الإلكتروني",
                "signup-phone-input":    "رقم الهاتف 213",
                "signup-password-input": "أدخل كلمة المرور",
                "signup-btn":            "إنشاء حساب",
                "have-account-text":     "هل لديك حساب بالفعل؟",
                "login-link":            "سجّل دخولك"
            }
        };

        // Elements that use placeholder instead of textContent
        const placeholderKeys = [
            "login-email-input", "login-password-input",
            "signup-name-input", "signup-email-input",
            "signup-phone-input", "signup-password-input"
        ];

        // Elements that use value (submit buttons)
        const valueKeys = ["login-btn", "signup-btn"];

        // ─────────────────────────────────────────────
        //  TOGGLE DROPDOWN
        // ─────────────────────────────────────────────
        function toggleLangDropdown(e) {
            e.stopPropagation();
            document.getElementById('langSwitcher').classList.toggle('open');
        }

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
            root.setAttribute('dir', t.dir);
            root.setAttribute('lang', t.lang);

            Object.keys(t).forEach(function (key) {
                if (['dir', 'lang', 'flag', 'label'].includes(key)) return;

                const el = document.getElementById(key);
                if (!el) return;

                if (placeholderKeys.includes(key)) {
                    el.setAttribute('placeholder', t[key]);
                } else if (valueKeys.includes(key)) {
                    el.value = t[key];
                } else {
                    el.textContent = t[key];
                }
            });

            // Update switcher button
            document.getElementById('currentFlag').textContent = t.flag;
            document.getElementById('currentLangLabel').textContent = t.label;

            // Update active state
            document.querySelectorAll('.lang-option').forEach(function (opt) {
                opt.classList.toggle('active', opt.dataset.lang === lang);
            });

            // Close dropdown
            document.getElementById('langSwitcher').classList.remove('open');

            // Save preference
            localStorage.setItem('trustcare_lang', lang);
        }

        // ─────────────────────────────────────────────
        //  RESTORE SAVED LANGUAGE ON LOAD
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