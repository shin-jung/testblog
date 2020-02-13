<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Repositories\Api\ArticleRepository;

class ArticleService
{
	protected $articleRepository;

	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}

	public function articleList()
	{
		return $this->articleRepository->showArticleList();
	}

	public function articleStore(Request $request)
	{
		return $this->articleRepository->articleStore($request);
	}

	public function oneArticle($id)
	{
		return $this->articleRepository->lookOneArticle($id);
	}

	public function updateThisArticle(Request $request, $id)
	{
		return $this->articleRepository->updateThisArticle($request, $id);
	}

	public function destorythisArticle($id)
	{
		return $this->articleRepository->destoryThisArticle($id);
	}
}