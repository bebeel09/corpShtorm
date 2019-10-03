<?php


Route::get('/', 'AdminController@index')->name('dashboard');

Route::get('/employee', 'EmployeeController@index')
	->name('employee');


#-------------------------------START EVENT ROUTE----------------------
Route::get('/events', 'EventsController@getPage')->name('events');

Route::post('events/addEvent', 'EventsController@addEvent')->name('addEvent');
Route::post('events/updateEvent', 'EventsController@updateEvent')->name('updateEvent');
Route::post('events/deleteEvent', 'EventsController@deleteEvent')->name('deleteEvent');
#-------------------------------END EVENT ROUTE----------------------

#-------------------------------START CATALOGPOST ROUTE----------------------
Route::resource('/catalogsPost', 'CatalogPostsController')->except(['update'])->names('catalogPost');
Route::post('/catalogsPost/update/{postId}', 'CatalogPostsController@update')->name('catalogPost.update');

Route::post('/catalogsPost/addCatalog', 'CatalogPostsController@addCatalog' )->name('addCatalog');

#-------------------------------END CATALOGPOST ROUTE------------------------

#-------------------------------START CATEGORY ROUTE----------------------
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
#-------------------------------END CATEGORY ROUTE----------------------


#-------------------------------START POST ROUTE----------------------
Route::resource('/posts', 'PostsController')
	->only(['index', 'create', 'edit', 'destroy', 'update'])
	->names('posts');

Route::post('/addpost', 'PostsController@store')->name('addpost.store');

Route::post('/posts/create/linkfile', 'FileManagerController@getFileURL');
Route::post('/posts/create/linkImg', 'FileManagerController@getImgURL')->name('create.linkImg');
#--------------------------------END POST ROUTE-------------------------

#-------------------------------START USER ROUTE----------------------
Route::resource('/users', 'UserController')
	->only(['index', 'create', 'edit', 'destroy', 'addOffice'])
	->names('users');

Route::post('/users/addOffice', 'UserController@addOffice')->name('addOffice');
Route::post('/users/addRegion', 'UserController@addRegion')->name('addRegion');
Route::post('/users/addDepartment', 'UserController@addDepartment')->name('addDepartment');

Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/updateUser', 'Auth\RegisterController@register')->name('updateUser');

Route::post('/users/update/{id}', 'UserController@update')->name('user.update');
#--------------------------------END USER ROUTE------------------------------
