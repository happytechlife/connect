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

Route::get('/', 'tag@select')->name('home');
Route::get('/tags/', 'tag@select')->name('tagView');
Route::post('/tags/create/', 'tag@store')->name('tagCreate');
Route::delete('/tags/delete/', 'tag@delete')->name('tagDelete');
Route::put('/tags/update/', 'tag@update')->name('tagUpdate');

Route::get('/linkedin/redirect', 'User@login')->name('login');
Route::get('/linkedin/callback', 'User@linkedin')->name('linkedinReturn');

Route::get('/users/compagny/', 'UserEntreprises@get')->name('getUserEntreprises');
Route::get('/users/compagny/add/', 'UserEntreprises@add')->name('addUserEntreprises');
Route::post('/users/compagny/add/', 'UserEntreprises@store')->name('storeUserEntreprises');
