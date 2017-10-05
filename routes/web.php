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
Auth::routes();
Route::group(['namespace' => 'Auth'], function() {
    Route::get('register/verify/{confirmationCode}', [
        'as' => 'confirmation_path',
        'uses' => 'RegisterController@confirm'
    ]);
});

Route::get('/','FormController@index')->name('homepage');
Route::post('/upload','FormController@upload');
Route::get('/upload','FormController@page');
Route::get('/download/{aid}','FormController@download');
Route::get('/edit/{aid}','FormController@edit');
Route::get('/searchajax','FormController@page');
Route::get('/searchajax/{arg}','FormController@searchajax');
Route::get('/page','FormController@page');
Route::get('/downloadshow/{aid}','FormController@downloadshow');

Route::get('/home', 'FormController@index');

