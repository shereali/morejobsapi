<?php

namespace App\Http\Middleware;

use Closure;

class localization
{
    public function handle($request, Closure $next)
    {
        $local = $request->route('lang') ?? 'en';

        app()->setLocale($local);

        return $next($request);
    }
}
