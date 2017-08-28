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
  $api->post('/login/email', 'App\Http\Controllers\Auth\LoginController@email');
  $api->post('/register', 'App\Http\Controllers\Auth\RegisterController@register');
  $api->post('/test', 'App\Http\Controllers\TestController@test');
  $api->post('/captcha/send/mobile', //['middleware' => 'api.throttle'],
    'App\Http\Controllers\Auth\CaptchaController@sendToMobile');

  // Restful api
  $api->get('/categories', 'App\Http\Controllers\CategoryController@index');
  $api->post('/categories', 'App\Http\Controllers\CategoryController@store');
  $api->get('/categories/category_id', 'App\Http\Controllers\CategoryController@show');
  $api->match(['put', 'patch'], '/categories/category_id', 'App\Http\Controllers\CategoryController@update');
  $api->delete('/categories/category_id', 'App\Http\Controllers\CategoryController@destory');
});

$api->version(['0.1.0'], ['middleware' => 'api.auth'], function($api) {
  $api->get('users/{id}', 'App\Http\Controllers\UserController@show');
});