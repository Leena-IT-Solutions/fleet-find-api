<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasWebRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->hasRole('Admin')) {
            return $next($request);
        }

        if ($request->user()) {
            return redirect()->route('organization.dashboard');
        }

        abort(403, 'Unauthorized. Only Admins are permitted to access this area.');
    }
}
