<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && ! $user->hasVerifiedEmail() && ! $request->routeIs('filament.app.auth.email-verification.prompt')) {
            return redirect()->route('filament.app.auth.email-verification.prompt');
        }

        return $next($request);
    }
}
