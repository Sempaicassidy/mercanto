@php
    $currentLocale = app()->getLocale();
    $isSwahili = $currentLocale === 'sw';
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#10b981">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>{{ $isSwahili ? 'Nje ya Mtandao - Mercanto PWA' : 'Offline - Mercanto PWA' }}</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="/icons/icon.svg">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: #09090b;
            color: #f4f4f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient emerald background glow */
        .ambient-glow {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(9, 9, 11, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        .offline-card {
            position: relative;
            z-index: 1;
            background: rgba(24, 24, 27, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), 0 0 30px rgba(16, 185, 129, 0.08);
        }

        .icon-halo {
            width: 96px;
            height: 96px;
            margin: 0 auto 1.75rem auto;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.1);
            border: 2px dashed rgba(239, 68, 68, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: pulse-ring 2.5s infinite;
        }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.25);
            }
            70% {
                box-shadow: 0 0 0 16px rgba(239, 68, 68, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        .icon-halo i {
            font-size: 2.75rem;
            color: #ef4444;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 1.25rem;
            text-transform: uppercase;
        }

        .offline-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.75rem;
            letter-spacing: -0.3px;
        }

        .offline-desc {
            font-size: 0.92rem;
            color: #a1a1aa;
            line-height: 1.6;
            margin-bottom: 1.75rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #27272a;
            border-radius: 12px;
            padding: 8px 16px;
            font-size: 0.85rem;
            color: #d4d4d8;
            margin-bottom: 1.5rem;
            width: 100%;
            justify-content: center;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ef4444;
            display: inline-block;
        }

        .btn-retry {
            background: #10b981;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 12px 24px;
            font-size: 0.95rem;
            font-weight: 700;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            text-decoration: none;
            cursor: pointer;
        }

        .btn-retry:hover {
            background: #059669;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
        }

        .btn-retry:active {
            transform: translateY(0);
        }

        .btn-back {
            background: transparent;
            color: #a1a1aa;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 10px 20px;
            font-size: 0.88rem;
            font-weight: 600;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 0.75rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        .offline-tips {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.8rem;
            color: #71717a;
            line-height: 1.5;
        }

        .offline-tips li {
            list-style: none;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>

    <div class="offline-card">
        <div class="brand-badge">
            <i class="bi bi-cart3"></i> Mercanto PWA
        </div>

        <div class="icon-halo" id="icon-halo">
            <i class="bi bi-wifi-off" id="icon-wifi"></i>
        </div>

        <h1 class="offline-title">
            {{ $isSwahili ? 'Huna Mtandao wa Intaneti' : 'You are Currently Offline' }}
        </h1>

        <p class="offline-desc">
            {{ $isSwahili 
                ? 'Inaonekana muunganisho wa mtandao umekatika. Mfumo wa Mercanto umehifadhi kurasa zako za hivi karibuni. Mara mtandao utakapopatikana, ukurasa utafunguka papo hapo.' 
                : 'It seems you lost your internet connection. Mercanto PWA safely retains your recently visited offline shell. As soon as connection is restored, the page will reload automatically.' }}
        </p>

        <div class="status-badge" id="status-badge">
            <span class="status-dot" id="status-dot"></span>
            <span id="status-text">{{ $isSwahili ? 'Nje ya Mtandao (Offline)' : 'Device is Offline' }}</span>
        </div>

        <button class="btn-retry" id="btn-retry" onclick="checkConnectionAndReload()">
            <i class="bi bi-arrow-clockwise"></i>
            <span>{{ $isSwahili ? 'Jaribu Tena Sasa' : 'Retry Connection' }}</span>
        </button>

        <a href="/" class="btn-back">
            <i class="bi bi-house"></i>
            <span>{{ $isSwahili ? 'Rudi Ukurasa Mkuu' : 'Return to Home' }}</span>
        </a>

        <div class="offline-tips">
            <ul class="p-0 m-0">
                <li><i class="bi bi-info-circle me-1"></i> {{ $isSwahili ? 'Angalia kama Wi-Fi au Data ya simu imewashwa.' : 'Check if Wi-Fi or Cellular Data is enabled.' }}</li>
                <li><i class="bi bi-lightning-charge me-1"></i> {{ $isSwahili ? 'Mercanto itajirekebisha kiotomatiki mara mtandao ukirudi.' : 'Mercanto will auto-reload once network restores.' }}</li>
            </ul>
        </div>
    </div>

    <script>
        function updateOnlineStatus() {
            const isOnline = navigator.onLine;
            const badge = document.getElementById('status-badge');
            const dot = document.getElementById('status-dot');
            const text = document.getElementById('status-text');
            const halo = document.getElementById('icon-halo');
            const icon = document.getElementById('icon-wifi');

            if (isOnline) {
                dot.style.backgroundColor = '#10b981';
                text.textContent = "{{ $isSwahili ? 'Mtandao Umerudi! Inapakia upya...' : 'Connection restored! Reloading...' }}";
                halo.style.backgroundColor = 'rgba(16, 185, 129, 0.15)';
                halo.style.borderColor = 'rgba(16, 185, 129, 0.5)';
                icon.className = 'bi bi-wifi text-success';
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                dot.style.backgroundColor = '#ef4444';
                text.textContent = "{{ $isSwahili ? 'Nje ya Mtandao (Offline)' : 'Device is Offline' }}";
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);

        function checkConnectionAndReload() {
            const btn = document.getElementById('btn-retry');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> {{ $isSwahili ? "Inajaribu..." : "Checking..." }}';
            btn.disabled = true;

            fetch('/manifest.json', { cache: 'no-store' })
                .then(res => {
                    if (res.ok) {
                        window.location.reload();
                    } else {
                        throw new Error('Offline');
                    }
                })
                .catch(() => {
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> <span>{{ $isSwahili ? "Jaribu Tena Sasa" : "Retry Connection" }}</span>';
                        const text = document.getElementById('status-text');
                        text.textContent = "{{ $isSwahili ? 'Bado haijaunganishwa. Angalia kifaa chako.' : 'Still offline. Check connection.' }}";
                    }, 600);
                });
        }
    </script>
</body>
</html>
