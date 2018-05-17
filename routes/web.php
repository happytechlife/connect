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

Route::get('/tags/', 'tag@select')->name('tagView');
Route::post('/tags/create/', 'tag@store')->name('tagCreate');
Route::delete('/tags/delete/', 'tag@delete')->name('tagDelete');
Route::put('/tags/update/', 'tag@update')->name('tagUpdate');

Route::get('/linkedin/redirect', 'User@login')->name('login');
Route::get('/linkedin/callback', 'User@linkedin')->name('linkedinReturn');
Route::get('/logout/', 'User@logout')->name('logout');

Route::get('/users/compagny/', 'UserEntreprises@get')->name('getUserEntreprises');
Route::get('/users/compagny/add/', 'UserEntreprises@add')->name('addUserEntreprises');
Route::post('/users/compagny/add/', 'UserEntreprises@store')->name('storeUserEntreprises');

Route::get('/entreprise/{slug}/','entreprise@view')->name('entreprise.view');
Route::get('/entreprises/','entreprise@index')->name('entreprises');
Route::post('/entreprise/new/','entreprise@store')->name('entreprise.new');
Route::put('/entreprise/update/','entreprise@update')->name('entreprise.update');
Route::delete('/entreprise/delete/','entreprise@delete')->name('entreprise.delete');
Route::get('/','Home@index')->name('home');

Route::get('/communaute/{slug}/','Commaunaute@view')->name('community.view');
Route::get('/communautes/','Commaunaute@index')->name('communities');
Route::post('/communaute/new/','Commaunaute@store')->name('community.new');
Route::put('/communaute/update/','Commaunaute@update')->name('community.update');
Route::delete('/communaute/delete/','Commaunaute@delete')->name('community.delete');
