<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\ArticleService;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    protected $articleService;

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
    			'message' => '成功，可以看到所有文章了。',
    			'data' => $showArticleList,
    		], 200);
    	} else {
    		return response()->json([
    			'success' => true,
    			'message' => '失敗, 現在沒有任何一篇文章。',
    			'data' => '',
    		], 200);
    	}
    }

    public function store(Request $request)
    {
    	$validator = validator::make($request->all(),[
    		'title' => 'required|alpha_dash',
    		'content' => 'required|alpha_dash',
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			'success' => false,
    			'message' => '新增文章失敗，標題和內文輸入錯誤。',
    			'data' => '',
    		], 404);
    	}

    	$articleStore = $this->articleService->articleStore($request);

    	if ($articleStore) {
    		return response()->json([
    			'success' => true,
    			'message' => '成功，你已新增文章。',
    			'data' => '',
    		], 200);
    	}
    }

    public function show($id = null)
    {
        $showArticle = $this->articleService->oneArticle($id);

        if (!is_numeric($id)||$showArticle->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => '抱歉，網址輸入錯誤。',
                'data' => '',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => '成功，你可以看到這篇文章了。',
                'data' => $showArticle,
            ], 200);
        }
    }

    public function update(Request $request, $id = null)
    {
        $validator = validator::make($request->all(),[
            'title' => 'required|alpha_dash',
            'content' => 'required|alpha_dash',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '更新文章失敗，標題和內文輸入錯誤。',
                'data' => '',
            ], 404);
        }

    	$updateArticle = $this->articleService->updateThisArticle($request, $id);

    	if ($updateArticle) {
    		return response()->json([
    			'success' => true,
    			'message' => '成功，你已更新文章。',
    			'data' => '',
    		], 200);
    	}
    }

    public function delete($id = null)
    {
    	$deleteArticle = $this->articleService->destoryThisArticle($id);
    	if ($deleteArticle) {
    		return response()->json([
    			'success' => true,
    			'message' => '成功，你已刪除文章。',
    			'data' => '',
    		], 200);
    	}
    }
}