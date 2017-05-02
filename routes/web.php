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
Auth::routes();

Route::get('/', 'HomeController@index');

// Route::get('blade', 'PagesController@blade');
//
// Route::get('users/create', ['uses' => 'UsersController@create']);
//
// Route::post('users', ['uses' => 'UsersController@store']);
//
// Route::get('about', function () {
//
// 	return view('pages.about');
// });
//
// Route::get('/profile/{username}/edit', 'ProfileController@edit');

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['authenticated', 'admin']], function(){
	Route::get('users', 'UsersController@index');

	Route::delete('users/{id}', ['uses' => 'UsersController@destroy', 'as' => 'delete']);

	Route::get('products/createBarcode', ['uses' => 'ProductsController@createBarcode']);

	Route::post('products/createBarcode', ['uses' => 'ProductsController@generateBarcodePDF']);

	Route::resource('costs', 'CostsController', ['only' => ['index', 'update']]);
});

Route::group(['middleware' => 'authenticated'], function(){
	Route::get('/profile/{username}', 'ProfileController@profile');

	Route::put('/profile/{username}', 'ProfileController@update');

	Route::resource('company', 'CompanyController', ['only' => ['index', 'update']]);

	Route::get('orders/byproductname', ['uses' => 'OrdersController@byproductname']);

	Route::get('orders/byproductnamedesc', ['uses' => 'OrdersController@byproductnamedesc']);

	Route::get('orders/byquantity', ['uses' => 'OrdersController@byquantity']);

	Route::get('orders/byquantitydesc', ['uses' => 'OrdersController@byquantitydesc']);

	Route::get('orders/bysellingprice', ['uses' => 'OrdersController@bysellingprice']);

	Route::get('orders/bysellingpricedesc', ['uses' => 'OrdersController@bysellingpricedesc']);

	Route::get('orders/bysubtotal', ['uses' => 'OrdersController@bysubtotal']);

	Route::get('orders/bysubtotaldesc', ['uses' => 'OrdersController@bysubtotaldesc']);

	Route::get('orders/bydiscount', ['uses' => 'OrdersController@bydiscount']);

	Route::get('orders/bydiscountdesc', ['uses' => 'OrdersController@bydiscountdesc']);

	Route::get('orders/bytotalamount', ['uses' => 'OrdersController@bytotalamount']);

	Route::get('orders/bytotalamountdesc', ['uses' => 'OrdersController@bytotalamountdesc']);

	Route::get('orders/bydatesold', ['uses' => 'OrdersController@bydatesold']);

	Route::get('orders/bydatesolddesc', ['uses' => 'OrdersController@bydatesolddesc']);

	Route::get('orders/bysoldby', ['uses' => 'OrdersController@bysoldby']);

	Route::get('orders/bysoldbydesc', ['uses' => 'OrdersController@bysoldbydesc']);

	Route::get('generateReceipt', ['as' => 'generateReceipt', 'uses' => 'OrdersController@generateReceipt']);

	Route::resource('orders', 'OrdersController', ['only' => ['index', 'create', 'store']]);

	Route::get('products/byproductname', ['uses' => 'ProductsController@byproductname']);

	Route::get('products/byproductnamedesc', ['uses' => 'ProductsController@byproductnamedesc']);

	Route::get('products/byquantity', ['uses' => 'ProductsController@byquantity']);

	Route::get('products/byquantitydesc', ['uses' => 'ProductsController@byquantitydesc']);

	Route::get('products/bydatebought', ['uses' => 'ProductsController@bydatebought']);

	Route::get('products/bydateboughtdesc', ['uses' => 'ProductsController@bydateboughtdesc']);

	Route::get('products/bypricebought', ['uses' => 'ProductsController@bydatebought']);

	Route::get('products/bypriceboughtdesc', ['uses' => 'ProductsController@bydateboughtdesc']);

	Route::get('products/bysellingprice', ['uses' => 'ProductsController@bysellingprice']);

	Route::get('products/bysellingpricedesc', ['uses' => 'ProductsController@bysellingpricedesc']);

	Route::get('products/bysupplier', ['uses' => 'ProductsController@bysupplier']);

	Route::get('products/bysupplierdesc', ['uses' => 'ProductsController@bysupplierdesc']);

	Route::post('products/additem', ['uses' => 'ProductsController@additem']);

	Route::resource('products', 'ProductsController', ['except' => ['edit', 'create']]);
});
