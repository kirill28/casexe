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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', function () {
    return redirect(route('home'));
});

Auth::routes();

Route::get('play', 'CasinoController@play')->name('play');
Route::get('convert/{moneyTransaction}', 'CasinoController@convertToBonus')->name('convert_to_bonus');
Route::post('apply-transaction/{moneyTransaction}', 'CasinoController@applyTransaction')
    ->name('apply_transaction');