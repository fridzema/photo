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

  Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'SiteController@index');
    Route::get('photo/{photoId}', 'SiteController@showPhoto')->name('photo');
		Route::get('photo_feed', 'Admin\PhotosController@getPhotoFeed');

		Route::group(['prefix' => 'admin'], function(){
			Auth::routes();
		});

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
  		Route::resource('photos', 'PhotosController');
  	});
  });
