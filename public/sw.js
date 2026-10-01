/**
 * Mercanto Progressive Web App (PWA) Service Worker
 * Version: 1.1.0
 */

const CACHE_NAME = 'mercanto-pwa-v1.1.0';

// Core shell assets to pre-cache on install
const PRECACHE_ASSETS = [
    '/offline',
    '/manifest.json',
    '/favicon.ico',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/icons/icon-maskable-192x192.png',
    '/icons/icon-maskable-512x512.png',
    '/icons/apple-touch-icon.png',
    '/icons/icon.svg',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
    'https://code.jquery.com/jquery-3.7.1.min.js'
];

// Service Worker Install
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(async (cache) => {
            for (const asset of PRECACHE_ASSETS) {
                try {
                    await cache.add(asset);
                } catch (err) {
                    console.warn('[Mercanto SW] Could not pre-cache asset:', asset, err);
                }
            }
        })
    );
    self.skipWaiting();
});

// Service Worker Activation & Cache Cleanup
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('[Mercanto SW] Removing old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Service Worker Fetch Handling
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Only handle GET requests; never intercept POST, PUT, DELETE, PATCH
    if (request.method !== 'GET') {
        return;
    }

    // Never cache mutable internal API / transactions / auth / session mutations
    if (
        url.pathname.startsWith('/api/') ||
        url.pathname.includes('/checkout') ||
        url.pathname.includes('/logout') ||
        url.pathname.includes('/switch-role') ||
        url.pathname.includes('/switch-business-mode') ||
        url.pathname.includes('/switch-language') ||
        url.pathname.startsWith('/locale/')
    ) {
        return;
    }

    // 1. Navigation requests (HTML pages) -> Network-First with Offline Fallback
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(request, responseClone);
                        });
                    }
                    return networkResponse;
                })
                .catch(async () => {
                    // When offline, try cached page first
                    const cachedResponse = await caches.match(request);
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    // Fallback to beautiful dedicated offline view
                    const offlineFallback = await caches.match('/offline');
                    if (offlineFallback) {
                        return offlineFallback;
                    }
                    return new Response(
                        '<!DOCTYPE html><html><head><meta charset="utf-8"><title>e-Duka - Nje ya Mtandao</title></head><body style="font-family:sans-serif;text-align:center;padding:50px;background:#09090b;color:#f4f4f5;"><h2>Huna Mtandao / You are Offline</h2><p>Tafadhali unganisha intaneti kisha ufungue tena ukurasa huu.</p></body></html>',
                        { headers: { 'Content-Type': 'text/html; charset=utf-8' } }
                    );
                })
        );
        return;
    }

    // 2. Static Assets (Icons, Images, Fonts, CSS, JS) -> Stale-While-Revalidate
    if (
        request.destination === 'style' ||
        request.destination === 'script' ||
        request.destination === 'image' ||
        request.destination === 'font' ||
        url.pathname.startsWith('/icons/') ||
        url.pathname === '/favicon.ico'
    ) {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                const fetchPromise = fetch(request)
                    .then((networkResponse) => {
                        if (networkResponse && networkResponse.status === 200) {
                            const responseClone = networkResponse.clone();
                            caches.open(CACHE_NAME).then((cache) => {
                                cache.put(request, responseClone);
                            });
                        }
                        return networkResponse;
                    })
                    .catch(() => cachedResponse);

                return cachedResponse || fetchPromise;
            })
        );
        return;
    }

    // 3. Default -> Try network, fallback to cache
    event.respondWith(
        fetch(request).catch(() => caches.match(request))
    );
});

// Listen for messages from frontend
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});
