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
        if ($request->user() && ($request->user()->hasRole('Admin') || $request->user()->hasRole('Organization'))) {
            return $next($request);
        }

        abort(403, 'Unauthorized. Only Admins and Organizations are permitted to access this area.');
    }
}
