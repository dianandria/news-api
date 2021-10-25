<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function(){
	Route::get('/news', 'NewsController@index')->name('news.index');
	Route::get('/news/{id}', 'NewsController@show')->name('news.show');
	Route::post('/news', 'NewsController@store')->name('news.store');
	Route::delete('/news/{id}', 'NewsController@destroy')->name('news.destroy');
	Route::put('/news/{id}', 'NewsController@update')->name('news.update');
});