<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role,$permission)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        if (!$request->user()->hasRole($role)) {
            abort(403);
        }
        if (!$request->user()->can($permission)) {
            abort(403);
        }
        return $next($request);
    }
}
