<?php
/**
 * Created by hupo.
 * @BLOG  : mycentos.com
 * @Date  : 2017/7/24-下午5:22
 * @Email : 317559272@qq.com
 */

namespace App\Api;


use App\Article;
use App\Category;
use Illuminate\Http\Request;

/**
 * Class HomeWapController
 * @package App\Api
 */
class HomeWapController
{
    /**
     * @var Category
     */
    protected $article;
    /**
     * @var Category
     */
    protected $category;
    /**
     * @var Request
     */
    protected $request;

    /**
     * HomeWapController constructor.
     * @param $article
     */
    public function __construct(Article $article, Category $category,Request $request)
    {
        $this->request = $request;
        $this->article = $article;
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWapCategory()
    {
        $category = $this->category->where(['pid' => 0])->get();
        return response()->json($category);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWapArticle()
    {
        $article = $this->article->with('category')->get();
        return response()->json($article);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWapArticleById()
    {   $id = $this->request->get('id');
        $article = $this->article->with('category')->where(['id'=>$id])->first();
        return response()->json($article);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWapArticleByCategory()
    {   $id = $this->request->get('category_id');
        $article = $this->article->with('category')->where(['category_id'=>$id])->get();
        return response()->json($article);

    }

}