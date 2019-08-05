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

Route::get('/', 'HomeController@index')->name('home');

Route::get('category/{slug}', 'CategoryController@index')->name('category');

//Route::resource('posts', 'PostController');

Route::get('admin', 'Admin\AdminController@index')->name('admin');

Route::get('admin/employee', 'Admin\EmployeeController@index')
    ->name('admin.employee');

Route::get('admin/categories', 'Admin\CategoryController@index')
    ->name('admin.categories');

Route::get('admin/categories/{category}/edit', 'Admin\CategoryController@edit')
    ->name('admin.categories.edit');

Route::get('admin/categories/create', 'Admin\CategoryController@create')
    ->name('admin.categories.create');

Route::post('admin/categories/store', 'Admin\CategoryController@store')
    ->name('admin.categories.store');

Route::patch('admin/categories/{category}', 'Admin\CategoryController@update')
    ->name('admin.categories.update');



Route::resource('admin/posts', 'Admin\PostsController')
    ->only(['index', 'create', 'edit'])
    ->names('admin.posts');



