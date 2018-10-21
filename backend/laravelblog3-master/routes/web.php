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

Route::get('/', function () {
    return view('welcome');
});

Route::get('blade', function () {
    return view('child');
});

Route::get('/', 'IndexController@index')->name('main');
  //article/1
Route::get('article/{id}','IndexController@show')->name('articleShow');

Route::post('page/add','IndexController@store')->name('articleStore');
Route::get('article/del/{id}','IndexController@delete')->name('articleDelete');
Route::get('/tag','IndexController@tagPageAdd')->name('articleTagAdd');
Route::get('page/add','IndexController@add')->name('addPageView');
//удаление тега
Route::get('tag/del/{id}','IndexController@deleteTeg')->name('tegDelete');
//доюавдение тега
Route::post('tag/add','IndexController@tagStore')->name('tagStore');
Route::get('layouts2', function () {
    return view('master');
});
Route::get('tag/{tagname}','IndexController@tagSearch')->name('tagSearch');


//аутентииакация
Route::get('auth/login', 'Auth\AuthController@getLogin')->name('autorization');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Маршруты регистрации...
Route::get('auth/register', 'Auth\RegisterController@getRegister')->name('registration');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('page/comment', 'IndexController@addComment')->name('addComment');
