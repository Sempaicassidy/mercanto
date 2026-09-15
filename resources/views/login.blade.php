<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Duka</title>

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
    <!-- React & ReactDOM -->
    <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>

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
            max-width: 480px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Subtle top pill accent matching screenshot */
        .top-accent-tab {
            width: 130px;
            height: 10px;
            background: #38bdf8;
            border-radius: 20px 20px 0 0;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }

        .login-title {
            font-size: 1.55rem;
            font-weight: 800;
            color: #2c2d30;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: -0.3px;
        }

        .form-wrapper {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
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
            border: 1px solid rgba(0, 0, 0, 0.02);
            padding: 0 1.75rem;
            height: 58px;
        }

        .pill-input-box:focus-within,
        .pill-input-box.active-focus {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border-color: rgba(0, 0, 0, 0.12);
            transform: translateY(-1px);
        }

        .pill-input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 1.05rem;
            font-weight: 500;
            color: #1f2937;
        }

        .pill-input::placeholder {
            color: #4b5563;
            font-weight: 600;
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
        }

        .password-toggle-btn:hover {
            color: #4b5563;
        }

        /* Submit Pill Button */
        .btn-pill-submit {
            background-color: #2e3033;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 1.2px;
            border: none;
            border-radius: 9999px;
            padding: 13px 46px;
            margin: 1.5rem auto 0 auto;
            display: inline-block;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: center;
        }

        .btn-pill-submit:hover {
            background-color: #078927ff;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .btn-pill-submit:active {
            transform: translateY(0);
        }

        /* Alert / Status Message */
        .login-alert {
            width: 100%;
            border-radius: 20px;
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 0.5rem;
            display: none;
        }
    </style>
</head>
<body>

    <div class="login-page-container">
        <!-- Top accent hint from screenshot -->
        <div class="top-accent-tab"></div>

        <h1 class="login-title">LOGIN FORM</h1>

        <!-- React Mount Root with SSR Fallback markup for instant display -->
        <div id="react-login-root" style="width: 100%;">
            <form class="form-wrapper" id="login-form">
                <!-- Alert box -->
                <div id="status-alert" class="login-alert alert alert-danger" role="alert"></div>

                <!-- Email Input -->
                <div class="pill-input-box">
                    <input 
                        type="text" 
                        id="input-username" 
                        class="pill-input" 
                        placeholder="username" 
                        required 
                        autocomplete="username"
                        autofocus
                    >
                </div>

                <!-- Password Input -->
                <div class="pill-input-box">
                    <input 
                        type="password" 
                        id="input-password" 
                        class="pill-input" 
                        placeholder="******" 
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" id="btn-toggle-password" class="password-toggle-btn" aria-label="Toggle password visibility">
                        <!-- Standard SVG Eye so it displays 100% reliably even without icon fonts -->
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submit Button -->
                <div style="text-align: center;">
                    <button type="submit" id="btn-login-submit" class="btn-pill-submit">
                        LOGIN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery & React Interactive Script -->
    <script>
        $(document).ready(function() {
            // jQuery smooth input focus animation
            $('.pill-input').on('focus', function() {
                $(this).closest('.pill-input-box').addClass('active-focus');
            }).on('blur', function() {
                $(this).closest('.pill-input-box').removeClass('active-focus');
            });

            // Password eye toggle functionality
            let isPasswordVisible = false;
            $('#btn-toggle-password').on('click', function() {
                isPasswordVisible = !isPasswordVisible;
                const passInput = $('#input-password');
                passInput.attr('type', isPasswordVisible ? 'text' : 'password');

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

            // Form Submit handling with jQuery + Bootstrap Feedback
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                const username = $('#input-username').val().trim();
                const pass = $('#input-password').val().trim();
                const alertBox = $('#status-alert');
                const submitBtn = $('#btn-login-submit');

                if (!username || !pass) {
                    alertBox.removeClass('alert-success').addClass('alert-danger')
                            .text('Please fill in your username and password.')
                            .stop(true, true).slideDown(250);
                    return;
                }

                submitBtn.prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    LOGIN...
                `);
                alertBox.stop(true, true).slideUp(200);

                setTimeout(function() {
                    submitBtn.prop('disabled', false).text('LOGIN');
                    alertBox.removeClass('alert-danger').addClass('alert-success')
                            .text('Login successful')
                            .stop(true, true).slideDown(250);
                }, 1000);
            });
        });
    </script>
</body>
</html>
