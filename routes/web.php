<?php

use Illuminate\Support\Facades\Route;

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
    return view('login');
});

Route::get('/','HomeController@home')->name('home');
Route::post('/login','HomeController@login')->name('login');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/produk','ProdukController@index')->name('list.produk');
    Route::get('/produk/list','ProdukController@show')->name('show.produk');
    Route::get('/produk/create','ProdukController@create')->name('store.produk');
    Route::post('/produk/added','ProdukController@added')->name('added.produk');
    Route::delete('/produk/delete/{id}','ProdukController@delete')->name('produk.destroy');
    Route::post('/produk/edit','ProdukController@edit')->name('edit.produk');
    Route::get('/produk/export','ProdukController@export')->name('export.produk');

    Route::get('/profil','HomeController@profil')->name('profil');

    Route::get('/logout', 'HomeController@logout')->name('logout');
});
