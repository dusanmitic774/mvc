<?php

// register your routes

Route::get('/', 'UsersController@index');
Route::get('/users/delete', 'UsersController@delete');
Route::get('/users/show', 'UsersController@show');
Route::get('/users/update', 'UsersController@update');
Route::get('/users/create', 'UsersController@create');
Route::post('/users/store', 'UsersController@store');

