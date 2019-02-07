<?php

namespace App\Http\Middleware;

use Closure;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check header request and determine localizaton
        $local = ($request->hasHeader('Accept-Language')) ? $request->header('Accept-Language') : 'vi';
        // set laravel localization
        app()->setLocale($local);
        // continue request
        return $next($request);
    }
}
