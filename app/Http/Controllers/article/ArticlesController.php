<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Article\Article;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArticlesController extends Controller
{
    private $lastArticles;
    private $perPage;
    private $pagination;

    public function __construct()
    {
        $this->setLastArticles(12);
        $this->setPerpage(12);
        $this->setPagination(12);
    }

    public function index()
    {
        $pagination = $this->getPagination();
        $articles = $this->getLastArticles();
        return view('article.index', compact(['pagination', 'articles']));
    }

    /**
     * Show the given article
     * @return view return blade view index.
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $comments = $article->comments()->get();
        return view('article.show', compact(['article', 'comments']));
    }

    /**
     * Show the form to create an article
     * @return view return blade view index.
     */
    public function create()
    {
        return view('article.create');

    }

    /**
     * Create an Article in the database
     * @param Request $request
     * @return view return blade view index.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'thumbnail' => 'required|mimes:jpeg,bmp,png,svg|max:2048',
            'subject' => 'required',
            'content' => 'required'
        ]);
        $user = auth()->user();
        $article = new Article;
        $article->fill($request->except('thumbnail'));
        $user->articles()->save($article);
        if ($article->save()) {
            if ($request->hasFile('thumbnail')) {
                Storage::makeDirectory('public/articles/thumbnails/' . $article->id);
                Image::make($request->thumbnail)->resize(384, 288)->save('storage/articles/thumbnails/' . $article->id . '/thumbnail.jpg');
            }

            flash('게시물이 작성되었습니다.');
            return redirect(route('article.index'));
        }
    }

    /**
     * Show the form to edit an article
     * @return view return blade view index.
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('article.edit', compact('article'));
    }

    /**
     * Create an Article in the database
     * @return view return blade view index.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'subject' => 'required',
            'content' => 'required'
        ]);

        $article = Article::findOrFail($id);
        $article->fill($request->all());
        $article->save();

        flash('게시물이 수정되었습니다.');
        return redirect(route('article.index'));
    }

    public function showLatestArticles($page)
    {
        $pagination = $this->getPagination();
        $articles = Article::get()->forPage($page, $this->getPerPage());
        return view('article.index', compact(['pagination', 'articles']));
    }

    public function destory($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        flash('게시물이 삭제되었습니다.');
        return redirect(route('article.index'));
    }

    public
    function setLastArticles($articles)
    {
        $latestArticles = -1 * $articles;
        if (Article::get()->count() < $articles) {
            $this->lastArticles = Article::get();
        } else {
            $this->lastArticles = Article::get()->take($articles);
        }
    }

    /**
     * @return mixed
     */
    public
    function getLastArticles()
    {
        return $this->lastArticles;
    }

    /**
     * @param $perPage
     */
    public
    function setPerpage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * @return mixed
     */
    public
    function getPerpage()
    {
        return $this->perPage;
    }

    /**
     * @param $pagination
     */
    public
    function setPagination($pagination)
    {
        try {
            $this->pagination = ceil(Article::get()->count() / $pagination);
        } catch (\DivisionByZeroError $error) {
            $this->pagination = Article::get()->count();
        }
    }

    /**
     * @return mixed
     */
    public
    function getPagination()
    {
        return $this->pagination;
    }

}