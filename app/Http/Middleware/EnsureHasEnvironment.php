<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasEnvironment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip environment check in demo mode — demo users always have an environment
        if (session('demo_mode')) {
            return $next($request);
        }

        if (auth()->check() && !auth()->user()->pos_environment_id) {
            // Check if they are trying to access the environment routes to avoid redirect loops
            if ($request->routeIs('environment.*') || $request->routeIs('logout')) {
                return $next($request);
            }

            if (auth()->user()->role === 'admin') {
                return redirect()->route('environment.create');
            } else {
                return redirect()->route('environment.join');
            }
        }

        return $next($request);
    }
}
