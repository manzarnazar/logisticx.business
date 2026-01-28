<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackUserRouteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $log = [
            'user_id'  => $user?->id ?? 'guest',
            'method'   => $request->method(),
            'path'     => $request->path(),
            'ip'       => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::channel('route_access')->info('Route accessed', $log);   // Log to a file

        return $next($request);
    }
}
