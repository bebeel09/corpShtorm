<?php


Route::get('/', 'AdminController@index')->name('dashboard');

Route::get('/employee', 'EmployeeController@index')
	->name('employee');

Route::get('/categories', 'CategoryController@index')
	->name('categories');

Route::get('/categories/{category}/edit', 'CategoryController@edit')
	->name('categories.edit');

Route::get('/categories/create', 'CategoryController@create')
	->name('categories.create');

Route::post('/categories/store', 'CategoryController@store')
	->name('store');

Route::patch('/categories/{category}', 'CategoryController@update')
	->name('update');

Route::resource('/posts', 'PostsController')
	->only(['index', 'create', 'edit'])
	->names('posts');

