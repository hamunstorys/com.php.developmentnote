<?php

Route::get('/', [
    'as' => 'index',
    'uses' => 'IndexController@index'
]);

Route::prefix('/auth')->group(function () {
    Route::group(['middleware' => ['web', 'guest']], function () {

        //사용자 가입
        Route::get('/register', [
            'as' => 'users.register.create',
            'uses' => 'auth\RegisterController@create'
        ]);
        Route::post('/register', [
            'as' => 'users.register.store',
            'uses' => 'auth\RegisterController@store'
        ]);
        Route::get('/confirm/{code}', [
            'as' => 'users.register.confirm',
            'uses' => 'auth\RegisterController@confirm'
        ])->where('code', '[\pL - \pN]{60}');

        //사용자 인증
        Route::get('/login', [
            'as' => 'users.sessions.create',
            'uses' => 'auth\LoginController@create'
        ]);
        Route::post('/login', [
            'as' => 'users.sessions.store',
            'uses' => 'auth\LoginController@store'
        ]);

        //비밀번호 초기화
        Route::get('/remind', [
            'as' => 'users.remind.create',
            'uses' => 'auth\RemindController@create'
        ]);

        Route::post('/remind', [
            'as' => 'users.remind.store',
            'uses' => 'auth\RemindController@store'
        ]);

        Route::get('/reset/{token}', [
            'as' => 'users.reset.edit',
            'uses' => 'auth\ResetController@create'
        ])->where('token', '[\pL-\pN]{64}');
        Route::post('/reset/', [
            'as' => 'users.reset.update',
            'uses' => 'auth\ResetController@store'
        ]);
    });

    Route::group(['middleware' => ['web', 'auth']], function () {

        Route::get('/logout', [
            'as' => 'users.sessions.destroy',
            'uses' => 'auth\LoginController@destroy'
        ]);

        Route::get('/edit/{id}', [
            'as' => 'users.edit.edit',
            'uses' => 'auth\EditController@edit'
        ]);

        Route::put('/edit/{id}', [
            'as' => 'users.edit.update',
            'uses' => 'auth\EditController@update'
        ]);

        Route::delete('/delete/{id}', [
            'as' => 'users.delete.destroy',
            'uses' => 'auth\DeleteController@destroy'
        ]);
    });
});

Route::group(['middleware' => ['web']], function () {
    Route::prefix('/article')->group(function () {
        Route::get('/', [
            'as' => 'article.index',
            'uses' => 'article\ArticlesController@index'
        ]);

        Route::post('/', [
            'as' => 'article.store',
            'uses' => 'article\ArticlesController@store'
        ])->middleware('auth');

        Route::get('/create', [
            'as' => 'article.create',
            'uses' => 'article\ArticlesController@create'
        ])->middleware('auth');

        Route::get('/{article}', [
            'as' => 'article.show',
            'uses' => 'article\ArticlesController@show'
        ]);

        Route::put('/{article}', [
            'as' => 'article.update',
            'uses' => 'article\ArticlesController@update'
        ])->middleware('auth');

        Route::delete('/{article}', [
            'as' => 'article.destroy',
            'uses' => 'article\ArticlesController@destroy'
        ])->middleware('auth');

        Route::get('/{article}/edit', [
            'as' => 'article.edit',
            'uses' => 'article\ArticlesController@edit'
        ])->middleware('auth');

        Route::get('/page/{page}', [
            'as' => 'article.showLatestArticles',
            'uses' => 'article\ArticlesController@showLatestArticles'
        ]);

        Route::resource('/comment', 'article\CommentsController')->middleware('auth');
    });

    Route::prefix('/search')->group(function () {
        Route::post('/articles', [
            'as' => 'search.articles.store',
            'uses' => 'search\SearchArticlesController@store'
        ]);

        Route::get(' / articles / select ={select}&query={query}&page ={page}', [
            'as' => 'search.articles.show',
            'uses' => 'search\SearchArticlesController@show'
        ]);
    });
});
