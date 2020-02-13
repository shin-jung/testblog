<?php

namespace App\Repositories\Api;

use Illuminate\Http\Request;
use App\Article;
use JWTAuth;

class ArticleRepository
{
	public function showArticleList()
	{
		return Article::all();
	}

	public function articleStore(Request $request)
	{
		return Article::create([
			'title' => $request->title,
			'content' => $request->content,
			'author' => JWTAuth::user()->name,
		]);
	}

	public function lookOneArticle($id)
	{
		return Article::where('id', $id)->get();
	}
}