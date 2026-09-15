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
    <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <!-- Babel for JSX compilation -->
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: #e5e7eb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 10px;
        }

        .login-heading {
            font-size: 1.35rem;
            font-weight: 700;
            color: #2b2b2b;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: -0.2px;
        }

        .custom-input-group {
            position: relative;
            background: #ffffff;
            border-radius: 50px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
        }

        .custom-input-group:focus-within {
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.08);
            border-color: rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        .custom-input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            padding: 1rem 1.75rem;
            font-size: 1.05rem;
            font-weight: 500;
            color: #1f2937;
            border-radius: 50px;
        }

        .custom-input::placeholder {
            color: #4b5563;
            font-weight: 600;
        }

        .password-toggle-btn {
            background: transparent;
            border: none;
            outline: none;
            padding: 0 1.5rem;
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .password-toggle-btn:hover {
            color: #4b5563;
        }

        .btn-custom-login {
            background-color: #2b2d30;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 1px;
            border: none;
            border-radius: 50px;
            padding: 0.85rem 3rem;
            display: block;
            margin: 1.75rem auto 0 auto;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-custom-login:hover {
            background-color: #18191b;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.22);
        }

        .btn-custom-login:active {
            transform: translateY(0);
        }

        .alert-custom {
            border-radius: 20px;
            font-size: 0.9rem;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>

    <div id="react-login-root"></div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- React + jQuery Component -->
    <script type="text/babel">
        const { useState, useEffect } = React;

        function LoginForm() {
            const [email, setEmail] = useState('');
            const [password, setPassword] = useState('');
            const [showPassword, setShowPassword] = useState(false);
            const [loading, setLoading] = useState(false);
            const [message, setMessage] = useState(null);

            useEffect(() => {
                // jQuery integration: Smooth intro fade-in and input highlight effect
                $('#login-container').hide().fadeIn(400);

                $('.custom-input').on('focus', function() {
                    $(this).parent().addClass('focused');
                }).on('blur', function() {
                    $(this).parent().removeClass('focused');
                });
            }, []);

            const handleSubmit = (e) => {
                e.preventDefault();
                if (!email || !password) {
                    setMessage({ type: 'danger', text: 'Tafadhali jaza barua pepe na nenosiri.' });
                    $('#feedback-alert').hide().fadeIn(300);
                    return;
                }

                setLoading(true);
                setMessage(null);

                // jQuery smooth feedback animation
                setTimeout(() => {
                    setLoading(false);
                    setMessage({ type: 'success', text: 'Kuingia kumefanikiwa! Tunakupeleka kwenye dashibodi...' });
                    $('#feedback-alert').hide().fadeIn(300);
                }, 1000);
            };

            return (
                <div id="login-container" className="login-wrapper">
                    <h2 className="login-heading">Login</h2>

                    {message && (
                        <div id="feedback-alert" className={`alert alert-${message.type} alert-custom`} role="alert">
                            {message.text}
                        </div>
                    )}

                    <form onSubmit={handleSubmit}>
                        {/* Email Input */}
                        <div className="custom-input-group">
                            <input
                                type="text"
                                className="custom-input"
                                placeholder="username"
                                value={username}
                                onChange={(e) => setUsername(e.target.value)}
                                autoFocus
                                required
                            />
                        </div>

                        {/* Password Input with Eye toggle */}
                        <div className="custom-input-group">
                            <input
                                type={showPassword ? "text" : "password"}
                                className="custom-input"
                                placeholder="******"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                            />
                            <button
                                type="button"
                                className="password-toggle-btn"
                                onClick={() => setShowPassword(!showPassword)}
                                aria-label="Toggle password visibility"
                                title={showPassword ? "Hide password" : "Show password"}
                            >
                                <i className={`bi ${showPassword ? 'bi-eye-slash' : 'bi-eye'}`}></i>
                            </button>
                        </div>

                        {/* Login Button */}
                        <button type="submit" className="btn-custom-login" disabled={loading}>
                            {loading ? (
                                <span>
                                    <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    LOGIN...
                                </span>
                            ) : (
                                "LOGIN"
                            )}
                        </button>
                    </form>
                </div>
            );
        }

        const root = ReactDOM.createRoot(document.getElementById('react-login-root'));
        root.render(<LoginForm />);
    </script>
</body>
</html>
