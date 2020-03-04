<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Controllers Within The "App\Http\Controllers\Admin" Namespace
Route::namespace('API')->group(function () {
	// main
	Route::get('app/data', 'AppController@index');


	Route::get('favourites', 'ProviderController@favourites');

	// providers
	Route::get('providers', 'ProviderController@index');
	Route::get('providers/{provider}', 'ProviderController@show');
	Route::get('providers/{provider}/services', 'ProviderController@services');
	Route::get('providers/{provider}/services/{service}', 'ProviderController@service');

	// orders
	// Route::get('orders' , 'OrdersController@index');
	Route::post('/orders' , 'OrdersController@store');

	// contact us
	Route::post('/contactus' , 'ContactController@store');

	// pages
	Route::get('pages', 'PagesController@index');
	Route::get('pages/{slug}', 'PagesController@index');
});