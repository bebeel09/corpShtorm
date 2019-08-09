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

//Route::get('/register', 'RegisterController@showRegistrationForm');
//Route::post('/register', 'RegisterController@register');
Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

// Profile
Route::get('/profile', 'ProfileController@index')->name('profile.index');
Route::match(['put', 'patch'],'/profile/{profile}/reset', 'ProfileController@updatePassword')->name('profile.updatePassword');
Route::match(['put', 'patch'],'/profile/{profile}', 'ProfileController@updateInfo')->name('profile.updateInfo');

//Route::get('category/{slug}', 'CategoryController@index')->name('category');
