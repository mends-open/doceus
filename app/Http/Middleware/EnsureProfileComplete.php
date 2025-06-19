<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->person && ! $user->person->isComplete() && ! $request->routeIs('filament.app.auth.profile')) {
            return redirect()->route('filament.app.auth.profile');
        }

        return $next($request);
    }
}
