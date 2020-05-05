<?php

use Illuminate\Http\Request;

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

Route::post('/signup', 'UserController@store');
Route::post('/login', 'UserController@login');
Route::get('/yes', 'UserController@confirm');
Route::get('/index', 'UserController@index');
Route::delete('/user/{user}', 'UserController@delete');
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', 'UserController@logout');
    Route::post('/feed-back', 'FeedbackController@store');
    Route::get('/feed-back', 'FeedbackController@index');
    Route::get('user/feed-back', 'UserController@show');
});
//Route::apiresource('list','TaskController');

Route::get('/list', 'ListController@index');
Route::post('/list', 'ListController@store');
Route::delete('/list/{list}', 'ListController@destroy');
Route::put('/list/{name}', 'ListController@update');

Route::post('/task', 'TaskController@store');

