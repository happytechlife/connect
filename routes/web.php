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


Route::get('/','View@home')->name('home');


Route::get('/linkedin/redirect', 'User@login')->name('login');
Route::get('/linkedin/callback', 'User@linkedin')->name('linkedinReturn');
Route::get('/logout/', 'User@logout')->name('logout');

Route::get('/communaute/{slug}/','View@community')->name('community.view');
Route::get('/tag/{slug}/','View@tag')->name('tag.view');

Route::get('/admin/communautes/','Admin@community')->name('admin.communities');
Route::get('/admin/communaute/add/','AdminCommunity@add')->name('admin.community.add');
Route::post('/admin/communaute/add/','AdminCommunity@addRequest')->name('admin.community.add.request');

Route::get('/admin/communaute/edit/{slug}/','AdminCommunity@edit')->name('admin.community.edit');
Route::post('/admin/communaute/edit/{slug}/','AdminCommunity@editRequest')->name('admin.community.edit.request');

Route::get('/admin/communaute/delete/{slug}/','AdminCommunity@delete')->name('admin.community.delete');

Route::get('/admin/tags/','Admin@tags')->name('admin.tags');
Route::get('/admin/tag/add/','AdminTags@add')->name('admin.tag.add');
Route::post('/admin/tag/add/','AdminTags@addRequest')->name('admin.tag.add.request');
Route::get('/admin/tag/edit/{slug}/','AdminTags@edit')->name('admin.tag.edit');
Route::post('/admin/tag/edit/{slug}/','AdminTags@editRequest')->name('admin.tag.edit.request');
Route::get('/admin/tag/delete/{id}/','AdminTags@delete')->name('admin.tag.delete');