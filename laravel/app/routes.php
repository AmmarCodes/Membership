<?php

Route::group(['before' => 'auth'], function() {
	Route::get('/', [
	            'as' => 'home',
	            function() {
					return View::make('hello');
				}
	]);

	Route::resource('members', 'MembersController');
});



// Confide routes
Route::group(['before' => 'auth'], function() {
	Route::get('users/create', 'UsersController@create');
	Route::post('users', 'UsersController@store');
});
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');
