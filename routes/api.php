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
Route::post('/login', 'Api\AuthController@login');

Route::post('/register', 'Api\AuthController@register');

Route::group(['middleware' => 'auth.jwt'], function(){

	Route::post('/logout', 'Api\AuthController@logout');

	Route::get('/user', 'Api\UserController@userList')->middleware('user');
});

Route::group(['middleware' => 'article'], function(){

	Route::get('/home', 'Api\ArticleController@index');

});

Route::fallback(function() {
	return response()->json([
		'success' => false,
		'message' => 'Sorry, can not find this web.',
		'data' => '',
	], 404);
});
