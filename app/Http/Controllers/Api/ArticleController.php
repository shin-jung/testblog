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
    			'message' => 'Success, you can see articles.',
    			'data' => $showArticleList,
    		], 200);
    	} else {
    		return response()->json([
    			'success' => false,
    			'message' => 'Sorry.',
    			'data' => '',
    		], 404);
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
    			'message' => 'Sorry, data could not be added.',
    			'data' => '',
    		], 404);
    	}

    	$articleStore = $this->articleService->articleStore($request);

    	if ($articleStore) {
    		return response()->json([
    			'success' => true,
    			'message' => 'Success, you have added article.',
    			'data' => '',
    		], 200);
    	}
    }

    public function show($id = null)
    {
    	$showArticle = $this->articleService->oneArticle($id);
    	if ($showArticle) {
    		return response()->json([
    			'success' => true,
    			'message' => 'Success, you can look this article.',
    			'data' => $showArticle,
    		], 200);
    	} else {
    		return response()->json([
    			'success' => false,
    			'message' => 'Sorry.',
    			'data' => '',
    		], 404);
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
                'message' => 'Sorry, data could not be added.',
                'data' => '',
            ], 404);
        }

    	$updateArticle = $this->articleService->updateThisArticle($request, $id);

    	if ($updateArticle) {
    		return response()->json([
    			'success' => true,
    			'message' => 'Success, you have updated the article.',
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
    			'message' => 'Success, you have deleted the article.',
    			'data' => '',
    		], 200);
    	} else {
    		return response()->json([
    			'success' => false,
    			'message' => 'Sorry, you have not deleted the article.',
    			'data' => '',
    		], 404);
    	}
    }
}
