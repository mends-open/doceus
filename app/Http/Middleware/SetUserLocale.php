<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App as AppFacade;

class SetUserLocale
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user && isset($user->language)) {
            AppFacade::setLocale($user->language->value);
        }

        return $next($request);
    }
}
