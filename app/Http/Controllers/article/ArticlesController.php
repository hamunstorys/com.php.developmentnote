<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Article\Article;
use Illuminate\Support\Facades\File;
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
    public function show(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $comments = $article->comments()->get();
        return view('article.show', compact(['article', 'comments']));
    }

    /**
     * Show the form to create an article
     * @return view return blade view index.
     */
    public function create(Request $request)
    {
        if ($request->user()->can('create', Article::class)) {
            return view('article.create');
        } else {
            flash('승인되지 않은 사용자 행위입니다.');
            return redirect()->back();
        }
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
            'subject' => 'required|unique:articles',
            'content' => 'required'
        ]);
        $user = $request->user();
        $article = new Article();
        $article->fill([
            'subject' => $request->get('subject'),
            'content' => $request->get('content'),
        ]);
        $user->articles()->save($article);
        $article->save();
        Article::whereSubject($request->get('subject'))->update([
            'thumbnail' => url('/') . '/storage/photos/' . $request->user()->id . '/articles/thumbnails/' . Article::whereSubject($request->get('subject'))->first()->id . '.jpg'
        ]);

        if ($request->hasFile('thumbnail')) {
            if (!File::isDirectory('storage/app/public/photos/articles/thumbnails/'))
                Storage::makeDirectory('public/photos/' . $request->user()->id . '/articles/thumbnails/');

            Image::make($request->thumbnail)->resize(384, 288)->save('storage/photos/' . $request->user()->id . '/articles/thumbnails/' . $article->id . '.jpg');
        }

        flash('게시물이 작성되었습니다.');
        return redirect(route('article.index'));
    }

    /**
     * Show the form to edit an article
     * @return view return blade view index.
     */
    public
    function edit(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        if ($request->user()->can('update', $article)) {
            return view('article.edit', compact('article'));
        } else {
            flash('승인되지 않은 사용자 행위입니다.');
            return redirect()->back();
        }
    }

    /**
     * Create an Article in the database
     * @return view return blade view index.
     */
    public
    function update(Request $request, $id)
    {

        $this->validate($request, [
            'subject' => 'required',
            'content' => 'required'
        ]);

        $article = Article::findOrFail($id);
        $article->update($request->all());;

        flash('게시물이 수정되었습니다.');
        return redirect(route('article.show',$id));
    }

    public
    function showLatestArticles($page)
    {
        $pagination = $this->getPagination();
        $articles = Article::get()->forPage($page, $this->getPerPage());
        return view('article.index', compact(['pagination', 'articles']));
    }

    public
    function destroy(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if ($request->user()->can('destroy', $article)) {

            Storage::delete('public/photos/' . $request->user()->id . '/articles/thumbnails/' . $article->id . '.jpg');
            $article->delete();

            flash('게시물이 삭제되었습니다.');
            return redirect(route('article.index'));

        } else {

            flash('승인되지 않은 사용자 행위입니다.');
            return redirect()->back();

        }
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