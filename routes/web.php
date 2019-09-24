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

use Illuminate\Http\Request;

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/files/{fileName}','Admin\FileManagerController@getFile');
Route::get('/img/{ImgName}','Admin\FileManagerController@getImg');
Route::get('/phone-directory', 'HomeController@getPhoneBookPage')->name('phoneBook');
Route::get('/profile/{id}','HomeController@getProfilePage')->name('profile');
Route::get('/avatar/{avatarName}', 'Admin\FileManagerController@getAvatar');
Route::get('events', 'Admin\EventsController@getFrontPage')->name('events');

Auth::routes();


Route::get('/news', 'HomeController@index')->name('news');
Route::get('category/{id}','HomeController@getListTypeCategory')->name('listTypeCategory');

    Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function (){
        Route::resource('posts','PostController')->names('blog.posts');
        Route::get('posts/{categorySlug}/{postSlug}', 'PostController@showPost');
        Route::resource('category','CategoryController')->names('blog.category');
    });