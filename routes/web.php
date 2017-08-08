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

  Route::group(['middleware' => ['frontend']], function () {
    Route::get('/', 'SiteController@index');
    Route::get('photo/{photoId}', 'SiteController@showPhoto')->name('photo');
		Route::get('photo_feed', 'PhotosController@getPhotoFeed');
  });

  Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {
  	Auth::routes();

		Route::group(['middleware' => ['auth']], function () {
	  	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
			Route::resource('photos', 'PhotosController');
		});
	});