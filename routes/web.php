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

/* Login */

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@doLogin');
Route::get('/logout', 'Auth\LoginController@logout');

/* Register */
Route::get('/register', 'HomeController@registrasi');
Route::post('/register', 'HomeController@doRegister');

Route::group(['middleware'=>['auth:web']], function() {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::post('/submit-cipher', 'HomeController@submitCipher');
    Route::post('/submit-enemies', 'HomeController@answer');
    Route::post('/guess', 'HomeController@guess');

    Route::get('/create_soal', 'HomeController@soal');
});