<!-- resources/views/login-sign-up.blade.php -->
<!DOCTYPE html>
<html lang="en" dir="ltr" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrustCare</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-icon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f2f5;
            padding: 20px;
        }

        .container {
            position: relative;
            max-width: 1000px;
            width: 100%;
            background: #fff;
            /* FIXED: min-height instead of fixed height so RTL/Arabic content doesn't overflow */
            min-height: 550px;
            height: auto;
            box-shadow: 0 10px 25px rgb(0, 74, 164);
            perspective: 2000px;
            border-radius: 12px;
            overflow: hidden;
        }

        #flip {
            display: none;
        }

        /* ─── COVER PANEL ─── */
        .cover {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            transform-style: preserve-3d;
            transition: all 0.8s cubic-bezier(0.645, 0.045, 0.355, 1);
            z-index: 100;
            transform-origin: left;
        }

        #flip:checked~.cover {
            transform: rotateY(-180deg);
        }

        .cover .front,
        .cover .back {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
        }

        .cover .back {
            transform: rotateY(180deg);
        }

        .cover img {
            position: absolute;
            height: 100%;
            width: 100%;
            object-fit: cover;
            z-index: 10;
        }

        .cover .text {
            position: absolute;
            z-index: 20;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(42, 71, 235, 0.15);
            padding: 0 40px;
            color: #fff;
            text-align: center;
        }

        .cover .text span {
            font-weight: 600;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .text-1,
        .text-3 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .text-2,
        .text-4 {
            font-size: 16px;
            font-weight: 300 !important;
        }

        /* ─── FORM CONTAINER ─── */
        .form-container {
            width: 100%;
            min-height: 550px;
            background: #fff;
            display: flex;
        }

        .login-form,
        .signup-form {
            width: 50%;
            /* FIXED: padding adjusted + overflow scroll as fallback */
            padding: 30px 50px;
            overflow-y: auto;
        }

        .title {
            font-size: 30px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            display: inline-block;
        }

        .title::after {
            content: '';
            display: block;
            width: 40px;
            height: 3px;
            background: #1b2d95;
            margin-top: 5px;
        }

        .input-boxes {
            margin-top: 10px;
        }

        .input-box {
            position: relative;
            height: 50px;
            width: 100%;
            /* FIXED: reduced margin so content fits in all languages */
            margin: 18px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            border-bottom: 2px solid #ddd;
            padding-left: 35px;
            font-size: 15px;
            transition: 0.3s;
            background: transparent;
        }

        .input-box input:focus {
            border-color: #1b2d95;
        }

        .input-box i {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            color: #1b2d95;
            font-size: 17px;
        }

        .button {
            margin-top: 28px;
        }

        .button input {
            width: 100%;
            height: 48px;
            background: #1b2d95;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.3s;
        }

        .button input:hover {
            background: #15247a;
        }

        .sign-up-text,
        .login-text {
            margin-top: 18px;
            font-size: 14px;
            color: #333;
        }

        .sign-up-text label,
        .login-text label {
            color: #1b2d95;
            cursor: pointer;
            font-weight: 500;
        }

        .sign-up-text label:hover,
        .login-text label:hover {
            text-decoration: underline;
        }

        /* ─── LANGUAGE SWITCHER ─── */
        .lang-switcher-wrap {
            position: fixed;
            top: 20px;
            right: 24px;
            z-index: 9999;
        }

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

        .lang-btn .chevron {
            font-size: 13px;
            color: #94a3b8;
            transition: transform 0.25s ease;
        }

        .lang-switcher.open .chevron {
            transform: rotate(180deg);
        }

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

        .lang-option:hover {
            background: #f1f5f9;
        }

        .lang-option.active {
            background: #eef2ff;
            color: #1b2d95;
            font-weight: 700;
        }

        .lang-option .lang-name {
            flex: 1;
        }

        .lang-option .check {
            font-size: 15px;
            color: #1b2d95;
            opacity: 0;
        }

        .lang-option.active .check {
            opacity: 1;
        }

        /* ─── RTL FIXES ─── */
        [dir="rtl"] .lang-switcher-wrap {
            right: auto;
            left: 24px;
        }

        [dir="rtl"] .lang-dropdown {
            right: auto;
            left: 0;
        }

        /* FIXED: RTL input alignment */
        [dir="rtl"] .input-box input {
            padding-left: 0;
            padding-right: 35px;
            text-align: right;
            direction: rtl;
        }

        [dir="rtl"] .input-box i {
            left: auto;
            right: 5px;
        }

        /* FIXED: RTL font */
        [dir="rtl"] .title,
        [dir="rtl"] .input-box input,
        [dir="rtl"] .sign-up-text,
        [dir="rtl"] .login-text,
        [dir="rtl"] .cover .text span {
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
        }

        [dir="rtl"] .title::after {
            margin-right: 0;
            margin-left: auto;
        }

        [dir="rtl"] .cover {
            left: 0;
            transform-origin: right;
        }

        [dir="rtl"] #flip:checked~.cover {
            transform: rotateY(180deg);
        }

        /* FIXED: RTL cover position — login form on right side */
        [dir="rtl"] .form-container {
            flex-direction: row-reverse;
        }

        /* Error / success messages */
        .alert-error {
            color: #dc2626;
            text-align: center;
            font-size: 13px;
            margin-bottom: 8px;
            background: #fef2f2;
            border-radius: 8px;
            padding: 8px 12px;
        }

        .alert-success {
            color: #16a34a;
            text-align: center;
            font-size: 13px;
            margin-bottom: 8px;
            background: #f0fdf4;
            border-radius: 8px;
            padding: 8px 12px;
        }
    </style>
</head>

<body>

    <!-- ─── LANGUAGE SWITCHER ─── -->
    <div class="lang-switcher-wrap">
        <div class="lang-switcher" id="langSwitcher">
            <button class="lang-btn" type="button" onclick="toggleLangDropdown(event)">
                <span id="currentFlag">🇬🇧</span>
                <span id="currentLangLabel">English</span>
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
    </div>
    <!-- ─── END LANGUAGE SWITCHER ─── -->

    <div class="container">
        <input type="checkbox" id="flip">

        <div class="cover">
            <div class="front">
                <img src="{{ asset('image/login page.PNG') }}" alt="">
                <div class="text">
                    <span class="text-1" id="cover-text-1">Trust us with the warranty on your devices</span><br>
                    <span class="text-2" id="cover-text-2">If you do not have an account, create one now</span>
                </div>
            </div>
            <div class="back">
                <img class="backImg" src="{{ asset('image/sing up page2.jpg') }}" alt="">
                <div class="text">
                    <span class="text-3" id="cover-text-3">Trust us with the warranty on your devices</span><br>
                    <span class="text-4" id="cover-text-4">Create an account now and join our community</span>
                </div>
            </div>
        </div>

        <div class="form-container">

            <!-- ── LOGIN FORM ── -->
            <div class="login-form">
                <div class="title" id="tc-login-title">Login</div>

                @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
                @endif

                <div class="input-boxes">
                    {{-- IMPORTANT: action uses route(), method POST, no JS interference --}}
                    <form action="{{ route('login') }}" method="POST" id="loginForm">
                        @csrf
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email"
                                id="inp-login-email"
                                placeholder="Enter your email"
                                value="{{ old('email') }}"
                                required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password"
                                id="inp-login-pass"
                                placeholder="Enter your password"
                                required>
                        </div>
                        <div class="button input-box">
                            <input type="submit" id="tc-login-btn" value="Login">
                        </div>
                    </form>
                    <div class="text sign-up-text">
                        <span id="tc-no-account">Don't have an account?</span>
                        <label for="flip" id="tc-signup-link">Sign up now</label>
                    </div>
                </div>
            </div>

            <!-- ── SIGN UP FORM ── -->
            <div class="signup-form">
                <div class="title" id="tc-signup-title">Sign up</div>

                @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
                @endif

                <div class="input-boxes">
                    <form action="{{ route('register') }}" method="POST" id="registerForm">
                        @csrf
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name"
                                id="inp-signup-name"
                                placeholder="Enter your username"
                                value="{{ old('name') }}"
                                required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email"
                                id="inp-signup-email"
                                placeholder="Enter your email"
                                value="{{ old('email') }}"
                                required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-phone"></i>
                            <input type="tel" name="phone"
                                id="inp-signup-phone"
                                placeholder="Phone number 213"
                                value="{{ old('phone') }}"
                                required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password"
                                id="inp-signup-pass"
                                placeholder="Enter your password"
                                required>
                        </div>
                        <div class="button input-box">
                            <input type="submit" id="tc-signup-btn" value="Sign up">
                        </div>
                    </form>
                    <div class="text sign-up-text">
                        <span id="tc-have-account">Already have an account?</span>
                        <label for="flip" id="tc-login-link">Login now</label>
                    </div>
                </div>
            </div>

        </div>{{-- end .form-container --}}
    </div>{{-- end .container --}}

    <script>
        // ─────────────────────────────────────────────────────
        //  TRANSLATIONS  (only UI labels — forms submit normally)
        // ─────────────────────────────────────────────────────
        const TC_TRANS = {
            en: {
                dir: "ltr",
                lang: "en",
                flag: "🇬🇧",
                label: "English",
                // cover
                "cover-text-1": "Trust us with the warranty on your devices",
                "cover-text-2": "If you do not have an account, create one now",
                "cover-text-3": "Trust us with the warranty on your devices",
                "cover-text-4": "Create an account now and join our community",
                // login
                "tc-login-title": "Login",
                "inp-login-email-ph": "Enter your email",
                "inp-login-pass-ph": "Enter your password",
                "tc-login-btn": "Login",
                "tc-no-account": "Don't have an account?",
                "tc-signup-link": "Sign up now",
                // signup
                "tc-signup-title": "Sign up",
                "inp-signup-name-ph": "Enter your username",
                "inp-signup-email-ph": "Enter your email",
                "inp-signup-phone-ph": "Phone number 213",
                "inp-signup-pass-ph": "Enter your password",
                "tc-signup-btn": "Sign up",
                "tc-have-account": "Already have an account?",
                "tc-login-link": "Login now"
            },
            fr: {
                dir: "ltr",
                lang: "fr",
                flag: "🇫🇷",
                label: "Français",
                "cover-text-1": "Faites-nous confiance pour la garantie de vos appareils",
                "cover-text-2": "Si vous n'avez pas de compte, créez-en un maintenant",
                "cover-text-3": "Faites-nous confiance pour la garantie de vos appareils",
                "cover-text-4": "Créez un compte maintenant et rejoignez notre communauté",
                "tc-login-title": "Connexion",
                "inp-login-email-ph": "Entrez votre e-mail",
                "inp-login-pass-ph": "Entrez votre mot de passe",
                "tc-login-btn": "Se connecter",
                "tc-no-account": "Vous n'avez pas de compte ?",
                "tc-signup-link": "S'inscrire",
                "tc-signup-title": "Inscription",
                "inp-signup-name-ph": "Nom d'utilisateur",
                "inp-signup-email-ph": "Entrez votre e-mail",
                "inp-signup-phone-ph": "Numéro de téléphone 213",
                "inp-signup-pass-ph": "Entrez votre mot de passe",
                "tc-signup-btn": "S'inscrire",
                "tc-have-account": "Vous avez déjà un compte ?",
                "tc-login-link": "Se connecter"
            },
            ar: {
                dir: "rtl",
                lang: "ar",
                flag: "🇩🇿",
                label: "العربية",
                "cover-text-1": "ثق بنا في ضمان أجهزتك",
                "cover-text-2": "إذا لم يكن لديك حساب، أنشئ واحدًا الآن",
                "cover-text-3": "ثق بنا في ضمان أجهزتك",
                "cover-text-4": "أنشئ حسابًا الآن وانضم إلى مجتمعنا",
                "tc-login-title": "تسجيل الدخول",
                "inp-login-email-ph": "أدخل بريدك الإلكتروني",
                "inp-login-pass-ph": "أدخل كلمة المرور",
                "tc-login-btn": "دخول",
                "tc-no-account": "ليس لديك حساب؟",
                "tc-signup-link": "سجّل الآن",
                "tc-signup-title": "إنشاء حساب",
                "inp-signup-name-ph": "اسم المستخدم",
                "inp-signup-email-ph": "البريد الإلكتروني",
                "inp-signup-phone-ph": "رقم الهاتف 213",
                "inp-signup-pass-ph": "كلمة المرور",
                "tc-signup-btn": "إنشاء حساب",
                "tc-have-account": "هل لديك حساب بالفعل؟",
                "tc-login-link": "سجّل دخولك"
            }
        };

        // Map: translation key → {id, attr}
        // "text"        → el.textContent
        // "placeholder" → el.placeholder
        // "value"       → el.value  (submit buttons)
        const TC_MAP = [{
                key: "cover-text-1",
                id: "cover-text-1",
                attr: "text"
            },
            {
                key: "cover-text-2",
                id: "cover-text-2",
                attr: "text"
            },
            {
                key: "cover-text-3",
                id: "cover-text-3",
                attr: "text"
            },
            {
                key: "cover-text-4",
                id: "cover-text-4",
                attr: "text"
            },
            {
                key: "tc-login-title",
                id: "tc-login-title",
                attr: "text"
            },
            {
                key: "inp-login-email-ph",
                id: "inp-login-email",
                attr: "placeholder"
            },
            {
                key: "inp-login-pass-ph",
                id: "inp-login-pass",
                attr: "placeholder"
            },
            {
                key: "tc-login-btn",
                id: "tc-login-btn",
                attr: "value"
            },
            {
                key: "tc-no-account",
                id: "tc-no-account",
                attr: "text"
            },
            {
                key: "tc-signup-link",
                id: "tc-signup-link",
                attr: "text"
            },
            {
                key: "tc-signup-title",
                id: "tc-signup-title",
                attr: "text"
            },
            {
                key: "inp-signup-name-ph",
                id: "inp-signup-name",
                attr: "placeholder"
            },
            {
                key: "inp-signup-email-ph",
                id: "inp-signup-email",
                attr: "placeholder"
            },
            {
                key: "inp-signup-phone-ph",
                id: "inp-signup-phone",
                attr: "placeholder"
            },
            {
                key: "inp-signup-pass-ph",
                id: "inp-signup-pass",
                attr: "placeholder"
            },
            {
                key: "tc-signup-btn",
                id: "tc-signup-btn",
                attr: "value"
            },
            {
                key: "tc-have-account",
                id: "tc-have-account",
                attr: "text"
            },
            {
                key: "tc-login-link",
                id: "tc-login-link",
                attr: "text"
            },
        ];

        function toggleLangDropdown(e) {
            e.stopPropagation();
            document.getElementById('langSwitcher').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#langSwitcher')) {
                document.getElementById('langSwitcher').classList.remove('open');
            }
        });

        function setLang(lang) {
            const t = TC_TRANS[lang];
            if (!t) return;

            // Direction
            const root = document.getElementById('html-root');
            root.setAttribute('dir', t.dir);
            root.setAttribute('lang', t.lang);

            // Apply translations
            TC_MAP.forEach(function(m) {
                var el = document.getElementById(m.id);
                if (!el || !t[m.key]) return;
                if (m.attr === 'text') el.textContent = t[m.key];
                else if (m.attr === 'placeholder') el.placeholder = t[m.key];
                else if (m.attr === 'value') el.value = t[m.key];
            });

            // Switcher button
            document.getElementById('currentFlag').textContent = t.flag;
            document.getElementById('currentLangLabel').textContent = t.label;

            // Active state
            document.querySelectorAll('.lang-option').forEach(function(opt) {
                opt.classList.toggle('active', opt.dataset.lang === lang);
            });

            document.getElementById('langSwitcher').classList.remove('open');
            localStorage.setItem('trustcare_lang', lang);
        }

        // Restore on load
        (function() {
            var saved = localStorage.getItem('trustcare_lang');
            if (saved && TC_TRANS[saved]) setLang(saved);
        })();
    </script>

</body>

</html>