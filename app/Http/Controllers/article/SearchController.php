<?php

namespace App\Http\Controllers\article;

use App\Http\Controllers\Controller;
use App\Models\article\Article;
use App\Models\article\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */

    private $pagination;

    public function __construct()
    {
        $this->setPagination(12);
    }

    public function index()
    {

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
        $pagination = $this->getPagination();
        $articles = DB::table('articles')->where('subject', 'like', $query . '%')->get();
        switch ($select) {
            case 0:
                if (Search::all()->where('query', '=', $query)->first() == null) {
                    $search = Search::create([
                        'query' => $query,
                        'selected' => $select,
                        'articles' => $articles,
                    ]);
                } else {
                    $search = Search::all()->where('query', '=', $query)->first();
                    $search->update(['count' => $search->count + 1, 'articles' => $articles]);
                }

                return view('article.index', compact(['pagination', 'articles', 'query']));
        };
    }


    protected
    function setPagination($pagination)
    {
        try {
            $this->pagination = ceil(Article::get()->count() / $pagination);
        } catch (\DivisionByZeroError $error) {
            $this->pagination = Article::get()->count();
        }
    }


    protected
    function getPagination()
    {
        return $this->pagination;
    }


}
