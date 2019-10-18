<?php


Route::get('/', 'AdminController@index')->name('dashboard');

Route::get('/employee', 'EmployeeController@index')
	->name('employee');


#-------------------------------START EVENT ROUTE----------------------
Route::group(['middleware' => ['role_or_permission:grant admin|posts editor|delete events|create events|edit events']], function () {
	Route::get('/events', 'EventsController@getPage')->name('events');

	Route::post('events/addEvent', 'EventsController@addEvent')->name('addEvent');
	Route::post('events/updateEvent', 'EventsController@updateEvent')->name('updateEvent');
	Route::post('events/deleteEvent', 'EventsController@deleteEvent')->name('deleteEvent');
});
#-------------------------------END EVENT ROUTE----------------------

#-------------------------------START CATALOGPOST ROUTE----------------------
Route::group(['middleware' => ['role_or_permission:grant admin|catalogs editor|delete postsCatalog|create postsCatalog|edit postsCatalog']], function () {
	Route::resource('/catalogPosts', 'CatalogPostsController')->except(['update'])->names('catalogPost');
	Route::post('/catalogsPost/update/{postId}', 'CatalogPostsController@update')->name('catalogPost.update');

	Route::post('/catalogsPost/addCatalog', 'CatalogPostsController@addCatalog')->name('addCatalog');
});
#-------------------------------END CATALOGPOST ROUTE------------------------

#-------------------------------START POST ROUTE----------------------
Route::group(['middleware' => ['role_or_permission:grant admin|posts editor|delete posts|create posts|edit posts']], function () {
	Route::resource('/posts', 'PostsController')
		->only(['index', 'create', 'edit', 'destroy', 'update'])
		->names('posts');
	Route::post('/addpost', 'PostsController@store')->name('addpost.store');

	Route::post('/posts/create/linkfile', 'FileManagerController@getFileURL');
	Route::post('/posts/create/linkImg', 'FileManagerController@getImgURL')->name('create.linkImg');
});

#--------------------------------END POST ROUTE-------------------------

#-------------------------------START USER ROUTE----------------------
Route::group(['middleware' => ['role_or_permission:grant admin|admin|create users|edit users|delete users']], function () {
	Route::resource('/users', 'UserController')
		->only(['index', 'create', 'edit', 'destroy'])
		->names('users');

		Route::post('/users/changePassword/{id}', 'UserController@changePasswordAdmin')->name('users.changePassword');

	Route::group(['middleware' => ['role_or_permission:admin|grant admin|edit rolesAndPermissions'], 'prefix' => 'users'], function () {
		Route::resource('permission', 'PermissionController')
			->only(['index', 'create', 'edit', 'destroy'])
			->names('users.permission');
		Route::post('permission/update/{id}', 'PermissionController@update')->name('users.permission.update');
	});
	
	
Route::post('/users/addOffice', 'UserController@addOffice')->name('addOffice');
Route::post('/users/addDepartment', 'UserController@addDepartment')->name('addDepartment');

Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/updateUser', 'Auth\RegisterController@register')->name('updateUser');

Route::post('/users/update/{id}', 'UserController@update')->name('user.update');
});

Route::group(['middleware' => ['role_or_permission:grant admin|admin|edit rolesAndPermissions']], function () {
	Route::resource('/role', 'RoleController')
	->only(['index', 'create', 'edit', 'destroy', 'update'])
	->names('roles');
});

#--------------------------------END USER ROUTE------------------------------
