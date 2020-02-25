<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = ($request->hasHeader('Accept-Language')) ? $request->header('Accept-Language') : config('app.locale');
        // set laravel localization
        app()->setLocale($locale);
        // continue request
        return $next($request);
    }
}
