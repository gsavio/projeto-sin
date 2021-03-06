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

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
	Route::get('/', 'HomeController@index');
	Route::get('home', 'HomeController@index')->name('home');
	Route::get('produtos', 'ProdutoController@index')->name('produtos');
	Route::get('pedidos', 'PedidoController@index')->name('pedidos');
	
	Route::resource('cliente', 'ClienteController');
	Route::resource('produto', 'ProdutoController')->except('show');
	Route::resource('pedido', 'PedidoController');

	// Pegar dados via JSON
	Route::get('json/clientes', 'ClienteController@listaClientesJson')->name('clientes.json');
	Route::get('json/produtos', 'ProdutoController@listarProdutosJson')->name('produtos.json');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});


