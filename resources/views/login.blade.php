@php
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isSwahili ? 'Ingia - Mercanto Multi-Tenant POS & Management' : 'Sign In - Mercanto Multi-Tenant POS & Management' }}</title>

    @include('partials.pwa_meta')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: #dedfe4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-page-container {
            width: 100%;
            max-width: 460px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Language Switcher Pills */
        .login-lang-pills {
            display: inline-flex;
            align-items: center;
            background: #ffffff;
            padding: 4px;
            border-radius: 9999px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.08);
            gap: 4px;
            margin-bottom: 1.5rem;
        }

        .login-lang-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .login-lang-pill:hover {
            color: #111827;
            background: #f3f4f6;
        }

        .login-lang-pill.active {
            background: #18181b;
            color: #ffffff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
        }

        /* Subtle top pill accent matching screenshot */
        .top-accent-tab {
            width: 130px;
            height: 10px;
            background: #18181b;
            border-radius: 20px 20px 0 0;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .login-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 0.5rem;
        }

        .login-brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #18181b;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 800;
        }

        .login-title {
            font-size: 1.65rem;
            font-weight: 800;
            color: #2c2d30;
            text-align: center;
            letter-spacing: -0.3px;
            margin-bottom: 0.25rem;
        }

        .login-subtitle {
            font-size: 0.86rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 1.75rem;
            font-weight: 500;
        }

        .form-wrapper {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* Field Group & Visible Labels */
        .field-group {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .field-label {
            font-size: 0.88rem;
            font-weight: 600;
            color: #374151;
            padding-left: 1.25rem;
            letter-spacing: 0.15px;
            user-select: none;
            cursor: pointer;
        }

        /* Pill Input Group */
        .pill-input-box {
            position: relative;
            background: #ffffff;
            border-radius: 9999px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            transition: all 0.2s ease-in-out;
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0 1.5rem;
            height: 58px;
        }

        .pill-input-box:focus-within,
        .pill-input-box.active-focus {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border-color: rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        .pill-input-box .input-icon {
            font-size: 1.15rem;
            color: #9ca3af;
            margin-right: 0.85rem;
            display: flex;
            align-items: center;
        }

        .pill-input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 1rem;
            font-weight: 500;
            color: #1f2937;
        }

        .pill-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
            opacity: 1;
        }

        /* Toggle Password Button */
        .password-toggle-btn {
            background: none;
            border: none;
            outline: none;
            padding: 4px;
            color: #9ca3af;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: color 0.15s ease;
            margin-left: 0.5rem;
        }

        .password-toggle-btn:hover {
            color: #374151;
        }

        /* Submit Pill Button */
        .btn-pill-submit {
            background-color: #2e3033;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.98rem;
            letter-spacing: 0.8px;
            border: none;
            border-radius: 9999px;
            padding: 15px 46px;
            margin: 0.5rem auto 0 auto;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(46, 48, 51, 0.25);
            transition: all 0.2s ease-in-out;
        }

        .btn-pill-submit:hover {
            background-color: #18181b;
            box-shadow: 0 8px 25px rgba(24, 24, 27, 0.35);
            transform: translateY(-2px);
        }

        .btn-pill-submit:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(46, 48, 51, 0.2);
        }

        .btn-pill-submit:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Alert and Notifications */
        .login-alert {
            display: none;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 12px 16px;
            margin-bottom: 0.5rem;
        }

        .login-alert.alert-danger {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .login-alert.alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .auth-footer-note {
            text-align: center;
            color: #6b7280;
            font-size: 0.8rem;
            margin-top: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Mobile-First Responsive Refinements */
        @media (max-width: 480px) {
            body {
                padding: 14px 10px;
                align-items: flex-start;
            }
            .login-card {
                padding: 1.75rem 1.25rem;
                border-radius: 20px;
            }
            .login-brand-title {
                font-size: 1.65rem;
            }
            .pill-input-box {
                height: 52px;
                padding: 0 1.15rem;
            }
            .btn-pill-submit {
                padding: 13px 20px;
                font-size: 0.92rem;
            }
            .login-lang-pill {
                padding: 5px 10px;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-page-container">
        <!-- Top Language Selector Toggle -->
        <div class="login-lang-pills">
            <a href="{{ url('/switch-language/sw') }}" class="login-lang-pill {{ $isSwahili ? 'active' : '' }}" title="Lugha ya Kiswahili">
                <span>🇹🇿 Kiswahili</span>
            </a>
            <a href="{{ url('/switch-language/en') }}" class="login-lang-pill {{ !$isSwahili ? 'active' : '' }}" title="English Language">
                <span>🇬🇧 English</span>
            </a>
        </div>

        <!-- Top accent hint -->
        <div class="top-accent-tab"></div>

        <div class="login-brand">
            <div class="login-brand-icon">
                <i class="bi bi-cart3"></i>
            </div>
            <h1 class="login-title mb-0">Mercanto</h1>
        </div>
        <p class="login-subtitle">{{ $isSwahili ? 'Mfumo wa Mauzo na Usimamizi wa Maduka (Multi-Tenant)' : 'Multi-Tenant POS & Store Management System' }}</p>

        <div style="width: 100%;">
            <form class="form-wrapper" id="login-form" method="POST" action="{{ url('/login') }}" novalidate>
                @csrf

                <!-- Alert box (AJAX & SSR fallback) -->
                <div id="status-alert" class="login-alert alert alert-danger" role="alert" aria-live="polite">
                    @if ($errors->any())
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                    @elseif (session('success'))
                        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    @endif
                </div>

                @if ($errors->any())
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const alert = document.getElementById('status-alert');
                            if (alert) alert.style.display = 'block';
                        });
                    </script>
                @elseif (session('success'))
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const alert = document.getElementById('status-alert');
                            if (alert) {
                                alert.classList.remove('alert-danger');
                                alert.classList.add('alert-success');
                                alert.style.display = 'block';
                            }
                        });
                    </script>
                @endif

                <!-- Username or Email Field -->
                <div class="field-group">
                    <label for="input-username" class="field-label">{{ $isSwahili ? 'Barua Pepe au Jina la Mtumiaji (Email / Username)' : 'Email or Username' }}</label>
                    <div class="pill-input-box">
                        <span class="input-icon">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <input 
                            type="text" 
                            id="input-username" 
                            name="username"
                            class="pill-input" 
                            placeholder="{{ $isSwahili ? 'mfano: meneja@eduka.co.tz au jina' : 'e.g. manager@eduka.co.tz or username' }}" 
                            value="{{ old('username') }}"
                            required 
                            autocomplete="username"
                            autofocus
                            aria-required="true"
                            spellcheck="false"
                            autocapitalize="none"
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div class="field-group">
                    <label for="input-password" class="field-label">{{ $isSwahili ? 'Nenosiri (Password)' : 'Password' }}</label>
                    <div class="pill-input-box">
                        <span class="input-icon">
                            <i class="bi bi-key-fill"></i>
                        </span>
                        <input 
                            type="password" 
                            id="input-password" 
                            name="password"
                            class="pill-input" 
                            placeholder="{{ $isSwahili ? 'Ingiza nenosiri lako' : 'Enter your password' }}" 
                            required
                            autocomplete="current-password"
                            aria-required="true"
                        >
                        <button 
                            type="button" 
                            id="btn-toggle-password" 
                            class="password-toggle-btn" 
                            aria-label="{{ $isSwahili ? 'Onyesha au ficha nenosiri' : 'Show or hide password' }}"
                            aria-controls="input-password"
                            aria-pressed="false"
                        >
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Help -->
                <div class="d-flex justify-content-between align-items-center px-3" style="font-size: 0.85rem;">
                    <label class="d-flex align-items-center gap-2 text-muted user-select-none" style="cursor: pointer;">
                        <input type="checkbox" name="remember" id="remember-me" class="form-check-input" style="cursor: pointer;">
                        <span>{{ $isSwahili ? 'Nikumbuke (Remember me)' : 'Remember me' }}</span>
                    </label>
                    <span class="text-muted" style="font-size: 0.78rem;">
                        <i class="bi bi-shield-lock-fill text-secondary me-1"></i> {{ $isSwahili ? 'Data Iliyolindwa' : 'Secure Data' }}
                    </span>
                </div>

                <!-- Submit Button -->
                <div style="text-align: center;">
                    <button type="submit" id="btn-login-submit" class="btn-pill-submit">
                        <i class="bi bi-box-arrow-in-right"></i> {{ $isSwahili ? 'INGIA (LOGIN)' : 'SIGN IN (LOGIN)' }}
                    </button>
                </div>

                <!-- Security & Tenant Identification Note -->
                <div class="auth-footer-note">
                    <i class="bi bi-database-check text-success"></i>
                    <span>{{ $isSwahili ? 'Mfumo unatambua kiotomatiki duka na nafasi (role) yako kupitia hifadhidata.' : 'System automatically identifies your store and user role from the database.' }}</span>
                </div>

                <!-- Quick Demo Accounts Helper -->
                <div class="demo-card mt-3 p-3 rounded-4" style="background: rgba(248, 250, 252, 0.95); border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span style="font-size: 0.78rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="bi bi-person-badge-fill text-primary me-1"></i> {{ $isSwahili ? 'Akaunti za Kujaribia (Bofya kuingia)' : 'Quick Demo Accounts (Click to Sign In)' }}
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1" style="font-size: 0.7rem; font-weight: 600;">
                            {{ $isSwahili ? 'Nenosiri' : 'Password' }}: <code class="text-dark">password</code> / <code class="text-dark">admin</code>
                        </span>
                    </div>

                    <div class="d-flex flex-wrap gap-2 pt-1">
                        <button type="button" class="btn btn-sm btn-dark demo-fill-btn d-flex align-items-center gap-1 px-3 py-1" data-user="admin" data-pass="password" style="border-radius: 9999px; font-size: 0.78rem; font-weight: 600;">
                            <span>👑 Super Admin</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-dark demo-fill-btn d-flex align-items-center gap-1 px-3 py-1" data-user="manager" data-pass="password" style="border-radius: 9999px; font-size: 0.78rem; font-weight: 600;">
                            <span>🏬 Meneja (Retail)</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-dark demo-fill-btn d-flex align-items-center gap-1 px-3 py-1" data-user="cashier" data-pass="password" style="border-radius: 9999px; font-size: 0.78rem; font-weight: 600;">
                            <span>💳 Keshia (POS)</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-dark demo-fill-btn d-flex align-items-center gap-1 px-3 py-1" data-user="wholesale" data-pass="password" style="border-radius: 9999px; font-size: 0.78rem; font-weight: 600;">
                            <span>🚚 Meneja wa Jumla</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-dark demo-fill-btn d-flex align-items-center gap-1 px-3 py-1" data-user="storekeeper" data-pass="password" style="border-radius: 9999px; font-size: 0.78rem; font-weight: 600;">
                            <span>📦 Mtunza Stoo</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Interactive Script -->
    <script>
        $(document).ready(function() {
            const IS_SWAHILI = {{ $isSwahili ? 'true' : 'false' }};
            const MSG_FILL_FIELDS = IS_SWAHILI 
                ? 'Tafadhali jaza jina la mtumiaji (au barua pepe) na nenosiri.' 
                : 'Please enter your username (or email) and password.';
            const MSG_VERIFYING = IS_SWAHILI 
                ? 'Inathibitisha na kutafuta ruhusa...' 
                : 'Verifying credentials...';
            const MSG_REDIRECTING = IS_SWAHILI 
                ? 'Umefanikiwa! Unaelekezwa...' 
                : 'Success! Redirecting...';
            const MSG_WELCOME = IS_SWAHILI ? 'Karibu' : 'Welcome';
            const MSG_DIRECTING_TO = IS_SWAHILI ? 'Unaelekezwa...' : 'Redirecting...';

            // Input focus animation styling
            $('.pill-input').on('focus', function() {
                $(this).closest('.pill-input-box').addClass('active-focus');
            }).on('blur', function() {
                $(this).closest('.pill-input-box').removeClass('active-focus');
            });

            // Clear danger status alert when user starts typing
            $('.pill-input').on('input', function() {
                const alertBox = $('#status-alert');
                if (alertBox.is(':visible') && alertBox.hasClass('alert-danger')) {
                    alertBox.stop(true, true).slideUp(180);
                }
            });

            // Password eye toggle functionality
            let isPasswordVisible = false;
            $('#btn-toggle-password').on('click', function() {
                isPasswordVisible = !isPasswordVisible;
                const passInput = $('#input-password');
                passInput.attr('type', isPasswordVisible ? 'text' : 'password');
                $(this).attr('aria-pressed', isPasswordVisible ? 'true' : 'false');
                $(this).attr('aria-label', isPasswordVisible ? (IS_SWAHILI ? 'Ficha nenosiri' : 'Hide password') : (IS_SWAHILI ? 'Onyesha nenosiri' : 'Show password'));

                if (isPasswordVisible) {
                    $('#eye-icon').html(`
                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 4.293-12-12 .708-.708 12 12-.708.708z"/>
                    `);
                } else {
                    $('#eye-icon').html(`
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    `);
                }
            });

            // Quick Demo button filler
            $(document).on('click', '.demo-fill-btn', function(e) {
                e.preventDefault();
                const user = $(this).data('user');
                const pass = $(this).data('pass');
                $('#input-username').val(user);
                $('#input-password').val(pass);
                $('#status-alert').stop(true, true).slideUp(180);
                $('#login-form').trigger('submit');
            });

            // Form Submit via AJAX to query database and authenticate user
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                const username = $('#input-username').val().trim();
                const password = $('#input-password').val().trim();
                const remember = $('#remember-me').is(':checked');
                const alertBox = $('#status-alert');
                const submitBtn = $('#btn-login-submit');

                if (!username || !password) {
                    alertBox.removeClass('alert-success').addClass('alert-danger')
                            .html('<i class="bi bi-exclamation-triangle-fill me-1"></i> ' + MSG_FILL_FIELDS)
                            .stop(true, true).slideDown(220);
                    if (!username) {
                        $('#input-username').focus();
                    } else {
                        $('#input-password').focus();
                    }
                    return;
                }

                const originalBtnHtml = submitBtn.html();
                submitBtn.prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    ${MSG_VERIFYING}
                `);
                alertBox.stop(true, true).slideUp(180);

                $.ajax({
                    url: "{{ url('/login') }}",
                    type: 'POST',
                    data: {
                        username: username,
                        password: password,
                        remember: remember ? 1 : 0,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(res) {
                        const roleName = (res.user && res.user.role) ? res.user.role.toUpperCase() : 'USER';
                        const tenantName = (res.user && res.user.tenant) ? res.user.tenant : 'Duka';
                        const modeLabel = (res.user && res.user.business_mode === 'wholesaler') 
                            ? (IS_SWAHILI ? 'Jumla (Wholesale)' : 'Wholesale') 
                            : (IS_SWAHILI ? 'Rejareja (Retail)' : 'Retail');

                        alertBox.removeClass('alert-danger').addClass('alert-success')
                                .html(`<i class="bi bi-check-circle-fill me-1"></i> ${MSG_WELCOME} <strong>${res.user?.name || 'User'}</strong> (${roleName}) &bull; ${tenantName} [${modeLabel}]. ${MSG_DIRECTING_TO}`)
                                .stop(true, true).slideDown(200);

                        submitBtn.html(`<i class="bi bi-check2 me-1"></i> ${MSG_REDIRECTING}`);

                        setTimeout(function() {
                            window.location.href = res.redirect;
                        }, 500);
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalBtnHtml);
                        let msg = IS_SWAHILI 
                            ? 'Taarifa za kuingia si sahihi. Tafadhali hakiki jina la mtumiaji au nenosiri.' 
                            : 'Invalid credentials. Please verify your username or password.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                            msg = xhr.responseJSON.errors[firstKey][0];
                        }
                        alertBox.removeClass('alert-success').addClass('alert-danger')
                                .html(`<i class="bi bi-shield-x me-1"></i> ${msg}`)
                                .stop(true, true).slideDown(220);
                    }
                });
            });
        });
    </script>
</body>
</html>
