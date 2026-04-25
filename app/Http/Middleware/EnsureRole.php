<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        // Super Admin can bypass all role checks
        if ($user->role->name === 'super_admin') {
            return $next($request);
        }

        foreach ($roles as $role) {
            if ($user->role->name === $role) {
                return $next($request);
            }
        }

        abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}
