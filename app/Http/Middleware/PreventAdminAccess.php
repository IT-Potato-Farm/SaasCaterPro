<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // abort(403, 'Admins cannot access this page.');
            // or redirect:
            // return redirect('/admin/dashboard')->with('error', 'Admins cannot access that page.');
            return redirect()->route('admin.reports')->with('error', 'Admins cannot access the landing page.');
        }
        return $next($request);
    }
}
