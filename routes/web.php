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

Route::get('/', "HomeController@index")->name('main');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/employee', 'HomeController@getPhoneBookPage')->name('employee');

Route::get('/files/{fileName}','Admin\FileManagerController@getFile');
Route::get('/public/Catalog/{folderCatalog}/{fileName}','Admin\FileManagerController@downloadCatalogFile');

Route::get('/img/{ImgName}','Admin\FileManagerController@getImg');

Route::get('/profile/{id}','HomeController@getProfilePage')->name('profile');
Route::get('/avatar/{userSlug}/{avatarName}', 'Admin\FileManagerController@getAvatar');
Route::get('events', 'Admin\EventsController@getFrontPage')->name('events');

Route::post('profile/{id}/changePassword', 'Admin\UserController@changePasswordOnlyUser')->name('changePassword');

Route::get('catalog/{catalogSlug}', 'HomeController@getCatalog')->name('catalog.show');
Route::get('catalog/{catalogSlug}/{catalogPostSlug}', 'Blog\PostController@showPostCatalog')->name('catalogPost.show');



Route::get('category/{slug}','HomeController@showCategory')->name('showCategory');
Route::get('category/{categorySlug}/{postSlug}', 'Blog\PostController@showPost')->name('showPost');
    Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function (){
        Route::resource('posts','PostController')->names('blog.posts');
        Route::resource('category','CategoryController')->names('blog.category');
            });