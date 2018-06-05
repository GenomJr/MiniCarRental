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


Route::get('/','PageController@index');

Route::get('/user','PageController@user');
Route::get('/agent','PageController@agent');

Auth::routes();
Route::resource('Car', 'CarsController');
Route::resource('Rent', 'RentController');
Route::get('/users', 'RentController@all_users');
Route::get('/home', 'HomeController@index');
