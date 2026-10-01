@php
    $pwaLocale = app()->getLocale();
    $pwaIsSwahili = $pwaLocale === 'sw';
@endphp

<!-- Mercanto PWA Meta & Icons -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#10b981">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Mercanto">
<meta name="application-name" content="Mercanto POS & ERP">
<meta name="msapplication-TileColor" content="#10b981">
<meta name="msapplication-TileImage" content="/icons/icon-192x192.png">
<link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png">
<link rel="icon" type="image/svg+xml" href="/icons/icon.svg">
<link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192x192.png">
<link rel="icon" type="image/png" sizes="512x512" href="/icons/icon-512x512.png">
<link rel="shortcut icon" href="/favicon.ico">

<style>
    /* Mercanto PWA Install Banner */
    .eduka-pwa-banner {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 999999;
        max-width: 420px;
        width: calc(100% - 32px);
        animation: edukaPwaSlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    @keyframes edukaPwaSlideUp {
        from {
            opacity: 0;
            transform: translateY(24px) scale(0.97);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .eduka-pwa-banner-card {
        background: #18181b;
        color: #f4f4f5;
        border: 1px solid rgba(16, 185, 129, 0.35);
        border-radius: 20px;
        padding: 16px 18px;
        box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.65), 0 0 24px rgba(16, 185, 129, 0.18);
        backdrop-filter: blur(16px);
    }

    .eduka-pwa-banner-header {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
    }

    .eduka-pwa-banner-icon {
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        overflow: hidden;
        background: #09090b;
        border: 1px solid rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .eduka-pwa-banner-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .eduka-pwa-banner-info {
        flex: 1;
        min-width: 0;
    }

    .eduka-pwa-banner-title {
        font-weight: 700;
        font-size: 0.96rem;
        color: #ffffff;
        letter-spacing: -0.2px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .eduka-pwa-badge {
        background: rgba(16, 185, 129, 0.2);
        color: #34d399;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 6px;
        border: 1px solid rgba(16, 185, 129, 0.3);
        text-transform: uppercase;
    }

    .eduka-pwa-banner-desc {
        font-size: 0.82rem;
        color: #a1a1aa;
        line-height: 1.35;
        margin-top: 3px;
    }

    .eduka-pwa-banner-close {
        background: transparent;
        border: none;
        color: #71717a;
        font-size: 1.5rem;
        line-height: 1;
        padding: 0 4px;
        cursor: pointer;
        transition: color 0.15s;
    }

    .eduka-pwa-banner-close:hover {
        color: #ffffff;
    }

    .eduka-pwa-banner-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .eduka-pwa-btn-dismiss {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #a1a1aa;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
    }

    .eduka-pwa-btn-dismiss:hover {
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
    }

    .eduka-pwa-btn-install {
        background: #10b981;
        border: none;
        color: #ffffff;
        padding: 6px 16px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.38);
        transition: all 0.15s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .eduka-pwa-btn-install:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(16, 185, 129, 0.48);
    }

    /* Network Status & Update Toast */
    .eduka-toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000000;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .eduka-toast-pill {
        pointer-events: auto;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        border-radius: 14px;
        background: #18181b;
        color: #f4f4f5;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.12);
        animation: edukaToastIn 0.3s ease;
        transition: all 0.25s ease;
    }

    @keyframes edukaToastIn {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .eduka-toast-offline {
        border-color: rgba(239, 68, 68, 0.5);
        background: rgba(24, 24, 27, 0.96);
    }

    .eduka-toast-online {
        border-color: rgba(16, 185, 129, 0.5);
        background: rgba(24, 24, 27, 0.96);
    }

    .eduka-toast-update {
        border-color: rgba(59, 130, 246, 0.5);
        background: rgba(24, 24, 27, 0.96);
    }

    .eduka-toast-btn {
        background: #10b981;
        color: #ffffff;
        border: none;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
    }

    /* iOS Modal Guide */
    .eduka-ios-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        z-index: 1000001;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 16px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .eduka-ios-card {
        background: #18181b;
        color: #f4f4f5;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        padding: 24px;
        max-width: 440px;
        width: 100%;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        animation: edukaPwaSlideUp 0.3s ease;
    }

    .eduka-ios-step {
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: left;
        margin: 12px 0;
        padding: 10px 14px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 12px;
        font-size: 0.85rem;
    }

    .eduka-ios-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #10b981;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .eduka-pwa-banner {
            bottom: 16px;
            right: 16px;
            left: 16px;
            width: auto;
            max-width: none;
        }
        .eduka-toast-container {
            top: 12px;
            left: 12px;
            right: 12px;
        }
    }
</style>

<!-- PWA Service Worker & Interactive Experience Script -->
<script>
    (function () {
        const isSwahili = {{ $pwaIsSwahili ? 'true' : 'false' }};
        let deferredPwaPrompt = null;
        let waitingWorker = null;

        // 1. Ensure Manifest Link in <head>
        if (!document.querySelector('link[rel="manifest"]')) {
            const manifestLink = document.createElement('link');
            manifestLink.rel = 'manifest';
            manifestLink.href = '/manifest.json';
            document.head.appendChild(manifestLink);
        }

        // 2. Register Service Worker with Auto Update Detection
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/sw.js')
                    .then(function (registration) {
                        console.log('[Mercanto PWA] Service Worker active with scope:', registration.scope);

                        // If already waiting update
                        if (registration.waiting) {
                            waitingWorker = registration.waiting;
                            showUpdateToast();
                        }

                        registration.onupdatefound = function () {
                            const newWorker = registration.installing;
                            if (newWorker) {
                                newWorker.onstatechange = function () {
                                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                        waitingWorker = newWorker;
                                        showUpdateToast();
                                    }
                                };
                            }
                        };
                    })
                    .catch(function (error) {
                        console.warn('[Mercanto PWA] Service Worker registration failed:', error);
                    });
            });

            // Reload when controller changes after skipWaiting
            let refreshing = false;
            navigator.serviceWorker.addEventListener('controllerchange', function () {
                if (!refreshing) {
                    refreshing = true;
                    window.location.reload();
                }
            });
        }

        // 3. Inject PWA UI Elements safely into body
        function ensurePwaElements() {
            if (!document.body) return;

            // Toast Container
            if (!document.getElementById('eduka-toast-container')) {
                const toastBox = document.createElement('div');
                toastBox.id = 'eduka-toast-container';
                toastBox.className = 'eduka-toast-container';
                document.body.appendChild(toastBox);
            }

            // Install Banner
            if (!document.getElementById('eduka-pwa-install-banner')) {
                const bannerDiv = document.createElement('div');
                bannerDiv.id = 'eduka-pwa-install-banner';
                bannerDiv.className = 'eduka-pwa-banner';
                bannerDiv.style.display = 'none';
                bannerDiv.setAttribute('role', 'dialog');
                bannerDiv.setAttribute('aria-live', 'polite');
                bannerDiv.innerHTML = `
                    <div class="eduka-pwa-banner-card">
                        <div class="eduka-pwa-banner-header">
                            <div class="eduka-pwa-banner-icon">
                                <img src="/icons/icon.svg" alt="Mercanto Logo" width="46" height="46">
                            </div>
                            <div class="eduka-pwa-banner-info">
                                <div class="eduka-pwa-banner-title">
                                    <span>${isSwahili ? 'Sakinisha Mercanto App' : 'Install Mercanto App'}</span>
                                    <span class="eduka-pwa-badge">PWA</span>
                                </div>
                                <div class="eduka-pwa-banner-desc">
                                    ${isSwahili ? 'Pata uzoefu wa haraka na uwezo wa kutumia hata bila browser.' : 'Fast, reliable POS & ERP native app experience on your device.'}
                                </div>
                            </div>
                            <button type="button" class="eduka-pwa-banner-close" onclick="dismissEdukaPwaBanner()" aria-label="Close">&times;</button>
                        </div>
                        <div class="eduka-pwa-banner-actions">
                            <button type="button" class="eduka-pwa-btn-dismiss" onclick="dismissEdukaPwaBanner()">
                                ${isSwahili ? 'Baadaye' : 'Not Now'}
                            </button>
                            <button type="button" class="eduka-pwa-btn-install" onclick="installEdukaPwa()">
                                <i class="bi bi-download"></i>
                                <span>${isSwahili ? 'Sakinisha Sasa' : 'Install Now'}</span>
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(bannerDiv);
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', ensurePwaElements);
        } else {
            ensurePwaElements();
        }

        // 4. Handle Install Prompt
        window.addEventListener('beforeinstallprompt', function (e) {
            e.preventDefault();
            deferredPwaPrompt = e;

            const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
            if (isStandalone) return;

            const dismissedAt = localStorage.getItem('eduka_pwa_dismissed_at');
            const now = Date.now();
            if (dismissedAt && (now - parseInt(dismissedAt, 10) < 2 * 24 * 60 * 60 * 1000)) {
                return;
            }

            setTimeout(function () {
                ensurePwaElements();
                const banner = document.getElementById('eduka-pwa-install-banner');
                if (banner && !isStandalone) {
                    banner.style.display = 'block';
                }
            }, 2500);
        });

        // 5. Global Functions
        window.installMercantoPwa = window.installEdukaPwa = function () {
            if (deferredPwaPrompt) {
                deferredPwaPrompt.prompt();
                deferredPwaPrompt.userChoice.then(function (choice) {
                    if (choice.outcome === 'accepted') {
                        console.log('[Mercanto PWA] User accepted installation');
                    }
                    deferredPwaPrompt = null;
                    const banner = document.getElementById('eduka-pwa-install-banner');
                    if (banner) banner.style.display = 'none';
                });
            } else if (isIosSafari()) {
                showIosInstallModal();
            } else {
                alert(isSwahili 
                    ? 'Kusakinisha Mercanto: Fungua menyu ya kivinjari chako (alama ya nukta 3) kisha bonyeza "Sakinisha App" au "Ongeza kwenye Skrini ya Kwanza".'
                    : 'To install Mercanto: Open browser menu and choose "Install App" or "Add to Home screen".');
            }
        };

        window.dismissEdukaPwaBanner = function () {
            const banner = document.getElementById('eduka-pwa-install-banner');
            if (banner) {
                banner.style.display = 'none';
                localStorage.setItem('eduka_pwa_dismissed_at', Date.now().toString());
            }
        };

        window.addEventListener('appinstalled', function () {
            console.log('[Mercanto PWA] App installed successfully');
            const banner = document.getElementById('eduka-pwa-install-banner');
            if (banner) banner.style.display = 'none';
            deferredPwaPrompt = null;
            showNetworkToast(isSwahili ? 'Mercanto App imesakinishwa kikamilifu!' : 'Mercanto App installed successfully!', 'online', 4000);
        });

        // 6. Network Status Notifications (Online/Offline)
        function showNetworkToast(message, type, duration = 3500) {
            ensurePwaElements();
            const container = document.getElementById('eduka-toast-container');
            if (!container) return;

            const existing = document.getElementById('eduka-net-toast');
            if (existing) existing.remove();

            const pill = document.createElement('div');
            pill.id = 'eduka-net-toast';
            pill.className = `eduka-toast-pill eduka-toast-${type}`;
            const icon = type === 'offline' 
                ? '<i class="bi bi-wifi-off text-danger"></i>' 
                : '<i class="bi bi-wifi text-success"></i>';

            pill.innerHTML = `
                ${icon}
                <span>${message}</span>
            `;
            container.appendChild(pill);

            if (duration > 0) {
                setTimeout(function () {
                    pill.style.opacity = '0';
                    pill.style.transform = 'translateY(-10px)';
                    setTimeout(() => pill.remove(), 250);
                }, duration);
            }
        }

        window.addEventListener('online', function () {
            showNetworkToast(
                isSwahili ? 'Mtandao Umerudi (Online) — Umeunganishwa kikamilifu.' : 'Back Online — System connected.',
                'online',
                3500
            );
        });

        window.addEventListener('offline', function () {
            showNetworkToast(
                isSwahili ? 'Huna Mtandao (Offline) — Kurasa zilizohifadhiwa zinafanya kazi.' : 'You are Offline — Browsing cached pages.',
                'offline',
                0 // Keep until online
            );
        });

        // 7. SW Update Notification
        function showUpdateToast() {
            ensurePwaElements();
            const container = document.getElementById('eduka-toast-container');
            if (!container || document.getElementById('eduka-update-toast')) return;

            const pill = document.createElement('div');
            pill.id = 'eduka-update-toast';
            pill.className = 'eduka-toast-pill eduka-toast-update';
            pill.innerHTML = `
                <i class="bi bi-arrow-repeat text-primary"></i>
                <span>${isSwahili ? 'Toleo jipya linapatikana' : 'New version available'}</span>
                <button type="button" class="eduka-toast-btn" onclick="applyEdukaPwaUpdate()">
                    ${isSwahili ? 'Pakia Upya' : 'Refresh'}
                </button>
            `;
            container.appendChild(pill);
        }

        window.applyEdukaPwaUpdate = function () {
            if (waitingWorker) {
                waitingWorker.postMessage({ type: 'SKIP_WAITING' });
            } else {
                window.location.reload();
            }
        };

        // 8. iOS Detection & Guide
        function isIosSafari() {
            const ua = window.navigator.userAgent;
            const isIos = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
            const isSafari = /Safari/.test(ua) && !/Chrome|CriOS|FxiOS/.test(ua);
            return isIos && isSafari;
        }

        function showIosInstallModal() {
            if (document.getElementById('eduka-ios-modal')) return;

            const modal = document.createElement('div');
            modal.id = 'eduka-ios-modal';
            modal.className = 'eduka-ios-modal';
            modal.onclick = function (e) {
                if (e.target === modal) modal.remove();
            };
            modal.innerHTML = `
                <div class="eduka-ios-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img src="/icons/icon.svg" width="32" height="32" alt="Logo">
                            <strong style="color:#ffffff;">${isSwahili ? 'Sakinisha Mercanto kwenye iOS' : 'Install Mercanto on iOS'}</strong>
                        </div>
                        <button type="button" class="eduka-pwa-banner-close" onclick="document.getElementById('eduka-ios-modal').remove()">&times;</button>
                    </div>
                    <p style="font-size:0.83rem;color:#a1a1aa;margin-bottom:14px;text-align:left;">
                        ${isSwahili ? 'Kwenye kifaa chako cha Apple (iPhone/iPad), fuata hatua hizi:' : 'On your iPhone/iPad, follow these simple steps:'}
                    </p>
                    <div class="eduka-ios-step">
                        <div class="eduka-ios-num">1</div>
                        <div>${isSwahili ? 'Bonyeza kitufe cha <strong>Share</strong> (alama ya mraba na mshale juu) chini ya Safari.' : 'Tap the <strong>Share</strong> button (box with upward arrow) in Safari.'}</div>
                    </div>
                    <div class="eduka-ios-step">
                        <div class="eduka-ios-num">2</div>
                        <div>${isSwahili ? 'Tembeza chini kisha chagua <strong>"Add to Home Screen"</strong> (Ongeza kwenye Skrini ya Kwanza).' : 'Scroll down and tap <strong>"Add to Home Screen"</strong>.'}</div>
                    </div>
                    <div class="eduka-ios-step">
                        <div class="eduka-ios-num">3</div>
                        <div>${isSwahili ? 'Bonyeza <strong>"Add"</strong> juu kulia kukamilisha.' : 'Tap <strong>"Add"</strong> in the top-right corner.'}</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-success w-100 mt-3 rounded-3 py-2 fw-bold" onclick="document.getElementById('eduka-ios-modal').remove()">
                        ${isSwahili ? 'Nimeelewa' : 'Got it'}
                    </button>
                </div>
            `;
            document.body.appendChild(modal);
        }
    })();
</script>
