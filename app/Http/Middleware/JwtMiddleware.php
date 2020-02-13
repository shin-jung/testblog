<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Token;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware extends BaseMiddleware
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
        try {
            if (!$token = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'success' => false,
                    'message' => '抱歉，你沒有拿到token。',
                    'data' => '',
                ], 401);
            }
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => '抱歉，你的token是無效的。',
                'data' => '',
            ], 401);
        } catch (TokenExpiredException $e) {
            try {
                $token = JWTAuth::refresh(JWTAuth::getToken());
                $response = $next($request);
                var_dump($token);
            } catch (JWTException $e) {
                return response()->json([
                    'success' => false,
                    'message' => '抱歉，你輸入的是就得token。',
                    'data' => '',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => '抱歉，你的token輸入錯誤。',
                'data' => '',
            ], 401);
        }
        return $this->setAuthenticationHeader($next($request), $token);
    }
}