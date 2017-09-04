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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function(){
  Route::get('/', function() {
    return 'aaa';
  });
  Route::post('/login/wechat', 'Auth\LoginController@wechat');
  Route::post('/login/mobile', 'Auth\LoginController@mobile');
});*/

$api = app('Dingo\Api\Routing\Router');

$api->version(['0.1.0'], function($api) {
  $api->post('/login/wechat', 'App\Http\Controllers\Auth\LoginController@wechat');
  $api->post('/login/mobile', 'App\Http\Controllers\Auth\LoginController@mobile');
  $api->post('/login', 'App\Http\Controllers\Auth\LoginController@login');
  $api->post('/register', 'App\Http\Controllers\UserController@store');
  $api->post('/test', 'App\Http\Controllers\TestController@test');
  $api->post('/captcha/send/mobile', //['middleware' => 'api.throttle'],
    'App\Http\Controllers\Auth\CaptchaController@sendToMobile');

  // Restful api

  

  $api->get('/categories', 'App\Http\Controllers\CategoryController@index');
  $api->get('/categories/{category_id}', 'App\Http\Controllers\CategoryController@show');
  $api->get('/categories/{category_id}/topics', 'App\Http\Controllers\TopicController@index');

  $api->get('/topics', 'App\Http\Controllers\TopicController@index');
  $api->get('/topics/{topic_id}', 'App\Http\Controllers\TopicController@show');
  // $api->post('/users/avatar', 'App\Http\Controllers\UserController@updateAvatar');

  $api->get('/topics/{topic_id}/replies', 'App\Http\Controllers\ReplyController@index');

});

$api->version(['0.1.0'], ['middleware' => 'api.auth'], function($api) {
  $api->get('/users/edit', 'App\Http\Controllers\UserController@edit');
  $api->get('/users/test', 'App\Http\Controllers\UserController@edit1');
  $api->patch('/users', 'App\Http\Controllers\UserController@update');
  $api->patch('/users/password', 'App\Http\Controllers\UserController@updatePassword');
  // $api->get('/users/edit_avatar', 'App\Http\Controllers\UserController@edit_avatar');
  $api->post('/users/avatar', 'App\Http\Controllers\UserController@updateAvatar');

  $api->post('/categories', 'App\Http\Controllers\CategoryController@store');
  $api->patch('/categories/{category_id}', 'App\Http\Controllers\CategoryController@update');
  $api->delete('/categories/{category_id}', 'App\Http\Controllers\CategoryController@destory');
  $api->post('/categories/{category_id}/topics', 'App\Http\Controllers\TopicController@store');

  $api->post('/topics', 'App\Http\Controllers\TopicController@store');
  $api->post('/topics/{topic_id}/vote', 'App\Http\Controllers\TopicController@vote');
  $api->delete('/topics/{topic_id}/vote', 'App\Http\Controllers\TopicController@unvote');
  $api->patch('/topic/{topic_id}', 'App\Http\Controllers\TopicController@update');
  $api->delete('/topic/{topic_id}', 'App\Http\Controllers\TopicController@destory');

  $api->get('/topics/replies/{reply_id}/edit', 'App\Http\Controllers\ReplyController@edit');
  $api->post('/topics/{topic_id}/replies', 'App\Http\Controllers\ReplyController@store');
  $api->patch('/topics/replies/{reply_id}', 'App\Http\Controllers\ReplyController@update');
  $api->delete('/topics/replies/{reply_id}', 'App\Http\Controllers\ReplyController@destory');
  $api->post('/topics/replies/{reply_id}/vote', 'App\Http\Controllers\ReplyController@vote');
  $api->delete('/topics/replies/{reply_id}/vote', 'App\Http\Controllers\ReplyController@unvote');
});

$api->version(['0.1.0'], function($api) {
  $api->get('/users/{id}', 'App\Http\Controllers\UserController@show');
});