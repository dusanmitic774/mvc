<?php

// register your routes
Route::get('/404', 'HomeController@notFound');


Route::get('/', 'UsersController@index');
Route::get('/users', 'UsersController@index');
Route::get('/users/show/{id}', 'UsersController@show');
Route::get('/users/create', 'UsersController@create');
Route::get('/users/edit/{id}', 'UsersController@edit');
Route::post('/users/update', 'UsersController@update');
Route::post('/users/delete', 'UsersController@delete');
Route::post('/users/store', 'UsersController@store');

// Logging in
Route::get('/users/login', 'LoginController@loginForm');
Route::post('/users/login', 'LoginController@login');
Route::get('/users/logout', 'LoginController@logOut');

// Upload image
Route::post('/users/upload/{id}', 'UsersController@upload');
