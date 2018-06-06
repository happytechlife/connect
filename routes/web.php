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

use Illuminate\Support\Facades\Response;

Route::get('/','View@home')->name('home');


Route::get('/profil/entreprises/', 'User@entrepriseView')->name('entreprise.profil');
Route::get('/profil/entreprises/add/{id}', 'UserEntreprises@add')->name('entreprise.add');
Route::get('/profil/entreprises/edit/{slug}', 'UserEntreprises@edit')->name('entreprise.edit');
Route::post('/profil/entreprises/add/{id}', 'UserEntreprises@addStore')->name('entreprise.add.store');
Route::put('/profil/entreprises/edit/{slug}', 'UserEntreprises@editStore')->name('entreprise.edit.store');
//Route::get('/profil/entreprises/delete/{slug}', 'User@entrepriseDelete')->name('entreprise.delete');
Route::get('/linkedin/redirect', 'User@login')->name('login');
Route::get('/linkedin/callback', 'User@linkedin')->name('linkedinReturn');
Route::get('/logout/', 'User@logout')->name('logout');

Route::get('/communaute/{slug}/','View@community')->name('community.view');
Route::get('/tag/{slug}/','View@tag')->name('tag.view');
Route::get('/entreprise/{slug}/','View@entreprise')->name('entreprise.view');

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

function getImageContentType($file)
{
    $mime = exif_imagetype($file);

    if ($mime === IMAGETYPE_JPEG)
        $contentType = 'image/jpeg';

    elseif ($mime === IMAGETYPE_GIF)
        $contentType = 'image/gif';

    else if ($mime === IMAGETYPE_PNG)
        $contentType = 'image/png';

    else
        $contentType = false;

    return $contentType;
}

Route::get('img/community/{type}/{file}', function($type,$file) {
    $filePath = storage_path().'/app/public/community/'.$type.'/'.$file;

    if ( (!$mimeType = getImageContentType($filePath)) or !file_exists($filePath)){
        return Response::make("File does not exist.", 404);
    }
    $fileContents = file_get_contents($filePath);
    return Response::make($fileContents, 200, array('Content-Type' => $mimeType));
})->name('community.img');
Route::get('img/tag/{file}', function($file) {
    $filePath = storage_path().'/app/public/tag/'.$file;

    if ( (!$mimeType = getImageContentType($filePath)) or !file_exists($filePath)){
        return Response::make("File does not exist.", 404);
    }
    $fileContents = file_get_contents($filePath);
    return Response::make($fileContents, 200, array('Content-Type' => $mimeType));
})->name('tag.img');

Route::get('img/entreprise/{file}', function($file) {
    $filePath = storage_path().'/app/public/entreprise/'.$file;

    if ( (!$mimeType = getImageContentType($filePath)) or !file_exists($filePath)){
        return Response::make("File does not exist.", 404);
    }

    $fileContents = file_get_contents($filePath);
    return Response::make($fileContents, 200, array('Content-Type' => $mimeType));
})->name('entreprise.img');


Route::get('requests/search/', 'Search@json')->name('search');
Route::get('requests/search/communities', 'Search@communities')->name('search.communities');
Route::get('requests/search/tags', 'Search@tags')->name('search.tags');