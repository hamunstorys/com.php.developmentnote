<?php

Route::get('/', [
    'as' => 'index',
    'uses' => 'HomeController@index'
]);

Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::prefix('/article')->group(function () {
        Route::get('/', [
            'as' => 'article.index',
            'uses' => 'article\ArticlesController@index'
        ]);

        Route::post('/', [
            'as' => 'article.store',
            'uses' => 'article\ArticlesController@store'
        ]);

        Route::get('/create', [
            'as' => 'article.create',
            'uses' => 'article\ArticlesController@create'
        ]);

        Route::get('/{article}', [
            'as' => 'article.show',
            'uses' => 'article\ArticlesController@show'
        ]);

        Route::put('/{article}', [
            'as' => 'article.update',
            'uses' => 'article\ArticlesController@update'
        ]);

        Route::delete('/{article}', [
            'as' => 'article.destroy',
            'uses' => 'article\ArticlesController@destroy'
        ]);

        Route::get('/{article}/edit', [
            'as' => 'article.edit',
            'uses' => 'article\ArticlesController@edit'
        ]);

        Route::get('/page/{page}', [
            'as' => 'article.showLatestArticles',
            'uses' => 'article\ArticlesController@showLatestArticles'
        ]);

        Route::resource('/comment', 'article\CommentsController');
    });

    Route::prefix('/search')->group(function () {
        Route::post('/articles', [
            'as' => 'search.articles.store',
            'uses' => 'search\ArticlesSearchController@store'
        ]);

        Route::get('/articles/select={select}&query={query}&page={page}', [
            'as' => 'search.articles.show',
            'uses' => 'search\ArticlesSearchController@show'
        ]);
    });
});

