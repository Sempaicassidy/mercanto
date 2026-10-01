<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Supported locales in Mercanto.
     *
     * @var array<string>
     */
    public const SUPPORTED_LOCALES = ['sw', 'en'];

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Allow explicit query parameter override (?lang=sw or ?locale=en)
        if ($request->has('lang') && in_array($request->query('lang'), self::SUPPORTED_LOCALES, true)) {
            session(['locale' => $request->query('lang')]);
        } elseif ($request->has('locale') && in_array($request->query('locale'), self::SUPPORTED_LOCALES, true)) {
            session(['locale' => $request->query('locale')]);
        }

        // 2. Resolve active locale from session, defaulting to Kiswahili ('sw')
        $locale = session('locale', config('app.locale', 'sw'));

        if (! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = 'sw';
        }

        // 3. Set application locale for Laravel translation system
        App::setLocale($locale);

        return $next($request);
    }
}
