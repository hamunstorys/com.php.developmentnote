<?php

Route::get('/', [
    'as' => 'index',
    'uses' => 'HomeController@index'
]);

Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('article', 'article\ArticlesController');
    Route::get('/article/page/{page}', [
        'as' => 'article.page',
        'uses' => 'article\ArticlesController@getView'
    ]);
    Route::post('/article/search/', [
        'as' => 'article.search.store',
        'uses' => 'article\SearchController@store'
    ]);
    
    Route::resource('article/comment', 'article\CommentsController');
});

