<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use App\Article;

class ArticleMiddleware
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
        if (!is_numeric($request->route('id'))){
            return response()->json([
                'success' => false,
                'message' => '抱歉，網址輸入錯誤。',
                'data' => '',
            ], 422);
        }

        $findAuthor = Article::where('id', $request->route('id'))->first();
        
        if (is_null($findAuthor)) {
            return response()->json([
                'success' => false,
                'message' => '抱歉，沒有這篇文章。',
                'data' => '',
            ], 403);
        }

        if (JWTAuth::user()->is_admin != 'admin' && JWTAuth::user()->name != $findAuthor->author) {
            return response()->json([
                'success' => false,
                'message' => '抱歉，你沒有權利做這件事。',
                'data' =>'',
            ], 403);
        }
        return $next($request);
    }
}
