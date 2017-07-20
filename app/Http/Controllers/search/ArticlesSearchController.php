<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\article\Article;
use App\Models\article\Search;
use App\Models\article\Select;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticlesSearchController extends Controller
{
    /* $perPage maxvalue = 12*/
    /* if($pagination value == $perPage*)*/

    private $perPage;
    private $pagination;

    public function __construct()
    {
        $this->setPerpage(12);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'query' => 'required'
        ]);
        $select = $request->select;
        $query = $request->__get('query');
        $this->setPagination(DB::table('articles')
            ->where(Select::get()->where('value', '=', $select)->first()->query, 'like', $query . '%')
            ->get(),12);
        $pagination = $this->getPagination();
        $articles = DB::table('articles')
            ->where(Select::get()->where('value', '=', $select)->first()->query, 'like', $query . '%')
            ->get()->forPage(1, $this->getPerPage());
        switch ($select) {
            case 0:
                if (Search::all()
                        ->where('query', '=', $query)
                        ->where('selected', '=', $select)
                        ->first() == null
                ) {
                    Search::create([
                        'query' => $query,
                        'selected' => $select,
                    ]);
                } else {
                    Search::all()
                        ->where('query', '=', $query)
                        ->where('selected', '=', $select)
                        ->first()->update([
                            'count' => +1,
                        ]);
                }
                return view('article.search.show', compact(['select', 'query', 'articles', 'pagination']));
        };
    }

    /**
     * @param $query
     * @param $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($select, $query, $page)
    {
        switch ($select) {
            case 0:
                $this->setPagination(DB::table('articles')
                    ->where(Select::get()->where('value', '=', $select)->first()->query, 'like', $query . '%')
                    ->get(),12);
                $pagination = $this->getPagination();
                $articles = Article::get()
                    ->where(Select::get()->where('value', '=', $select)->first()->query, 'like', $query)
                    ->forPage($page, $this->getPerPage());
                return view('article.search.show', compact(['select', 'query', 'pagination', 'articles']));
        }
    }

    /**
     * @param $perPage
     */
    public function setPerpage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * @return mixed
     */
    public function getPerpage()
    {
        return $this->perPage;
    }

    /**
     * @param $pagination
     */

    /**
     * @return mixed
     */

    public function setPagination($articles, $pagination)
    {
        try {
            $this->pagination = ceil($articles->count() / $pagination);
        } catch (\DivisionByZeroError $error) {
            $this->pagination = Article::get()->count();
        }
    }


    public function getPagination()
    {
        return $this->pagination;
    }

}
