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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')
	->group(function () {
		
		Route::name('product.')
			->prefix('products')
			->group(function() {

				Route::get('/', 'ProductController@index')->name('index');
				
				Route::get('create/', 'ProductController@create')->name('create');
				Route::post('/', 'ProductController@store')->name('store');
				
				Route::get('{id}/edit/', 'ProductController@edit')->name('edit');
				Route::put('{id}/', 'ProductController@update')->name('update');
				
				Route::delete('{id}/', 'ProductController@destroy')->name('destroy');
				
				Route::get('{id}/', 'ProductController@show')->name('show');

			}
		);

		// Route::resources([
		// 	'articles' => 'ArticleController',
		// 	'comments' => 'CommentController',
		// ]);

	}
);