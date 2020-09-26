<?php

// register your routes
Route::get('/404', 'HomeController@notFound')->name('404');


Route::get('/', 'UsersController@index')->name('home');
Route::get('/users', 'UsersController@index')->name('users');
Route::get('/users/show/{id}', 'UsersController@show')->name('users.show');
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::get('/users/edit/{id}', 'UsersController@edit')->name('users.edit');
Route::post('/users/update', 'UsersController@update')->name('users.update');
Route::post('/users/delete', 'UsersController@delete')->name('users.delete');
Route::post('/users/store', 'UsersController@store')->name('users.store');

// Logging in
Route::get('/users/login', 'LoginController@loginForm')->name('users.loginForm');
Route::post('/users/login', 'LoginController@login')->name('users.login');
Route::get('/users/logout', 'LoginController@logOut')->name('users.logout');

// Upload image
Route::post('/users/upload/{id}', 'UsersController@upload')->name('users.upload');
