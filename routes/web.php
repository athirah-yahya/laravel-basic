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

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('Web')
	->group(function () {
		
		Route::name('product.')
			->prefix('products')
			->group(function() {

				Route::get('/', 'ProductController@index')->name('index');
				Route::post('/', 'ProductController@store')->name('store');
				Route::get('create/', 'ProductController@create')->name('create');
				Route::get('{id}/', 'ProductController@show')->name('show');

			}
		);

		// Route::resources([
		// 	'articles' => 'ArticleController',
		// 	'comments' => 'CommentController',
		// ]);

	}
);


// Route::get('products/', function() {
// 	return view('product.index');
// })->name('product.index');

// Route::get('products/create/', function() {
// 	return view('product.create');
// })->name('product.create');

// Route::get('products/{id}/', function($id) {
// 	return view('product.show', ['id' => $id]);
// })->name('product.show');
