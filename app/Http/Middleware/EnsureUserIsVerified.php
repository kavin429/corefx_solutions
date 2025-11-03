<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->isFullyVerified()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Your account must be verified to access this section.');
        }

        return $next($request);
    }
}
