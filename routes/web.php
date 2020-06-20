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


Route::get('/','HomeController@welcome')->name('welcome');

Route::post('/upload-file','HomeController@uploadFile')->name('uploadFile');

Route::get('{id}/delete','HomeController@delete')->name('delete');
