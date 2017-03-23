<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');

Route::get('blade', 'PagesController@blade');

Auth::routes();

Route::get('users/create', ['uses' => 'UsersController@create']);

Route::post('users', ['uses' => 'UsersController@store']);

/*Route::get('users', function() {
	$users = [
		'0' => [
			'first_name' => 'Renato',
			'last_name' => 'Hysa',
			'location' => 'Albania'
		],
		'1' => [
			'first_name' => 'Jessica',
			'last_name' => 'Alba',
			'location' => 'USA'
		]
	];
	return $users;
});*/

Route::get('about', function () {
	
	return view('pages.about');
});

Route::get('string', function () {
	return 'HELLO';
});



Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'authenticated'], function(){
	Route::get('users', 'UsersController@index');
	
	Route::resource('products', 'ProductsController');
	
	Route::resource('orders', 'OrdersController');
	
	Route::get('profile', 'PagesController@profile');

	Route::get('settings', 'PagesController@settings');
});
