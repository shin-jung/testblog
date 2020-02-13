<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\ArticleService;

class ArticleController extends Controller
{
    protected $articleService

    public function __construct(ArticleService $articleService)
    {
    	$this->articleService = $articleService;
    }

    public function index()
    {
    	$showArticleList = $this->articleService->articleList();
    	if ($showArticleList) {
    		return response()->json([
    			'success' => true,
    			'message' => 'Success, you can see articles.',
    			'data' => $showArticleList,
    		], 200);
    	}
    }
}
