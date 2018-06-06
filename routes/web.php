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

Route::get('/about','PageController@about');


Auth::routes();
Route::resource('Car', 'CarsController');
Route::resource('Rent', 'RentController');
Route::get('/users', 'CarsController@all_users');
Route::get('/user/{id}', 'CarsController@user_all_cars');
Route::get('/home', 'HomeController@index');
