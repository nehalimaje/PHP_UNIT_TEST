<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth_token = $request->header('Authorization');
        
        if ($auth_token !== 'Bearer secrete-auth-token') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
