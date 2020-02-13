<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!JWTAuth::user() || JWTAuth::user()->is_admin != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, you can not see users.',
                'data' => '',
            ], 403);
        }
        return $next($request);
    }
}
