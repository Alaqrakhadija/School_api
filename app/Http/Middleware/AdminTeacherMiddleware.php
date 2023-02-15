<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminTeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role == 'admin' || $request->user()->role == 'teacher') {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
