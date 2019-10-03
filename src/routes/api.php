<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'middleware' => [ 'api' ] ], function () {

    Route::group([ 'middleware' => [ 'auth:api' ] ], function () {

        Route::post('/api/blog', 'ktourvas\LaravelBlog\Http\Controllers\ArticlesController@create');

        Route::put('/api/blog/{article}', 'ktourvas\LaravelBlog\Http\Controllers\ArticlesController@update')
            ->middleware('can:update,article')
        ;

        Route::put('/api/blog/{article}/media', 'ktourvas\LaravelBlog\Http\Controllers\ArticlesController@addMedia')
            ->middleware('can:update,article')
        ;

    });

    Route::get('/api/blog', 'ktourvas\LaravelBlog\Http\Controllers\ArticlesController@index');

    Route::get('/api/blog/{article}', 'ktourvas\LaravelBlog\Http\Controllers\ArticlesController@view');

});
