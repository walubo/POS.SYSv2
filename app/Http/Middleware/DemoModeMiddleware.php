<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DemoModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Clear demo mode if accessing guest/auth routes directly
        if ($request->is('login') || $request->is('register*') || $request->is('password/*') || $request->is('forgot-password') || $request->is('reset-password*')) {
            session()->forget('demo_mode');
        }

        if (session()->has('demo_mode') && session()->get('demo_mode') === true) {
            if (!app()->environment('testing')) {
                // Point the SQLite connection to the demo sqlite file
                Config::set('database.connections.sqlite.database', database_path('demo.sqlite'));
                
                // Force Laravel to reconnect with the updated config
                DB::purge('sqlite');
            }

            // Re-resolve the authenticated user from the demo database.
            // The auth guard may have cached the user from the real DB
            // (loaded by earlier middleware in the pipeline).
            $guard = Auth::guard();
            if ($guard->check()) {
                $userId = $guard->id();
                // Clear the cached user and re-fetch from the demo DB
                $guard->setUser(
                    \App\Models\User::find($userId)
                );
            }
        }

        return $next($request);
    }
}
