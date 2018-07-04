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
})->name('welcome');

Route::get('/test', function() {
    return view('test');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/handle')->group(function() {
    Route::get('/facebook', 'SocialiteController@callback')->name('handle.facebook');
});

Route::prefix('login')->group(function() {
    Route::get('/facebook', 'SocialiteController@redirect')->name('login.facebook');
});

Route::get('facebook', 'FacebookController@index')->middleware('auth')->name('facebook');

Route::middleware(['auth', 'role:5'])->group(function () {
    Route::prefix('admin')->group(function() {
        Route::get('/', 'AdminController@index');
    });
});

Route::group(['middleware' => [
    'auth'
]], function(){
    Route::get('/user', 'GraphController@retrieveUserProfile');
});

// Route::get('/facebook', 'FacebookController@index');
//
// Route::get('/facebook/callback', 'FacebookController@callback');
