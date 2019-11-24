<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TopController@index');

Route::get('/question/{question_id}', 'QuestionDetailController@index');
Route::get('/tag/{tag_id}', 'SearchController@tag');
Route::get('/search', 'SearchController@search');
Route::post('/sort', 'TopController@sort');

Route::get('/user/{user_id}', 'UserController@index');

Route::group(['middleware' => 'auth'], function() {
	// 質問投稿
	Route::get('/question', 'QuestionController@index');
	Route::post('/question', 'QuestionController@index');
	Route::post('/question/confirm', 'QuestionController@questionConfirm');
	Route::post('/question/complete', 'QuestionController@questionInsert');
	// 質問補足
	Route::get('/question/{question_id}/addition', 'QuestionController@addition');
	Route::post('/question/{question_id}/addition', 'QuestionController@addition');
	Route::post('/question/{question_id}/addition/confirm', 'QuestionController@additionConfirm');
	Route::post('/question/{question_id}/addition/complete', 'QuestionController@additionUpdate');
	// 回答
	Route::post('/question/answer', 'QuestionDetailController@answer');
	// 返信
	Route::post('/question/reply', 'QuestionDetailController@reply');
	// ベストアンサー
	Route::post('/question/best_answer', 'QuestionDetailController@bestAnswer');
	// 質問にいいね
	Route::post('/question/good_question', 'QuestionDetailController@goodQuestion');
	// 回答にいいね
	Route::post('/question/good_answer', 'QuestionDetailController@goodAnswer');
	// ユーザー情報
	Route::post('/user/info', 'UserController@info');
	// ユーザー情報変更確認
	Route::post('/user/info/confirm', 'UserController@confirm');
	// ユーザー情報変更
	Route::post('/user/info/conplete', 'UserController@update');
	// パスワード変更
	Route::post('/user/password', 'UserController@password');
	Route::post('/user/password/complete', 'UserController@passwordUpdate');
	// 退会ページ
	Route::post('/user/unsubscribe', 'UserController@unsubscribe');
	Route::post('/user/unsubscribe/complete', 'UserController@delete');

});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
