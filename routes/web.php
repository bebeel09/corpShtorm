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

// Авторизация
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Далее идут страницы которые доступны после авторизации

Route::group(['middleware' => 'auth'], function() {
	// Главная страница
	Route::get('/', "HomeController@index")->name('main');

	// Сотрудники
	Route::get('/employee', 'HomeController@getPhoneBookPage')->name('employee');

	// События
	Route::get('events', 'Admin\EventsController@getFrontPage')->name('events'); // Почему Admin??

	// Поиск
	Route::post('/search', "SearchController@list");

	// Профиль
	Route::group(['prefix'=>'profile'], function(){
		Route::get('{id}','HomeController@getProfilePage')->name('profile');
		Route::post('{id}/changePassword', 'Admin\UserController@changePasswordOnlyUser')->name('changePassword');
	});
});




// Тут надо разбираться

Route::get('/files/{fileName}','Admin\FileManagerController@getFile');
Route::get('/public/Catalog/{folderCatalog}/{fileName}','Admin\FileManagerController@downloadCatalogFile');
Route::get('/img/{ImgName}','Admin\FileManagerController@getImg');
Route::get('/avatar/{userSlug}/{avatarName}', 'Admin\FileManagerController@getAvatar');

Route::get('category/{slug}','HomeController@showCategory')->name('showCategory');
Route::get('category/{categorySlug}/{postSlug}', 'Blog\PostController@showPost')->name('showPost');
Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function (){
	Route::resource('posts','PostController')->names('blog.posts');
	Route::resource('category','CategoryController')->names('blog.category');
});
Route::get('catalog/{catalogSlug}', 'HomeController@getCatalog')->name('catalog.show');
Route::get('catalog/{catalogSlug}/{catalogPostSlug}', 'Blog\PostController@showPostCatalog')->name('catalogPost.show');

