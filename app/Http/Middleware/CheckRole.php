<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $guard = Auth::getDefaultDriver();

        if (!Auth::guard($guard)->check()) {
            if ($guard === 'admin') {
                return redirect()->route('admin.login');
            }
            return redirect()->route('login');
        }

        $user = Auth::guard($guard)->user();

        if (empty($roles)) {
            return $next($request);
        }

        if (!in_array($user->role, $roles)) {
            if ($guard === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}