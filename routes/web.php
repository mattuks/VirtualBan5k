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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/transactions', 'TransactionController@index')->name('all-transactions');
Route::get('/transactions/{id}', 'TransactionController@show')->name('account-transactions');
Route::get('/transaction/{id}', 'TransactionController@create')->name('transaction-create');
Route::post('/transaction', 'TransactionController@store')->name('transaction-store');
Route::get('/account', 'AccountController@index');
Route::get('/account/create', 'AccountController@create')->name('account-create');
Route::post('/account/store', 'AccountController@store')->name('account-store');
