<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->role == 'admin') {
            return $next($request);
        }

        if ($request->user()->role == $role) {
            if ($role == 'teacher') {
                $userId = $request->user()->teacher->id;
            } else {
                $userId = $request->user()->student->id;
            }

            if ($request->route($role)->id == $userId) {
                return $next($request);
            } else {
                return response()->json(['not the same id']);
            }
            // return response()->json(['route id'=>$request->route($role)->id,
            // 'userid'=>$userId
            // ]);
        }

        abort(403, 'Unauthorized action.');
    }
}
