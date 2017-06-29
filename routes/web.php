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

Route::get('/', function() {
   return redirect('notes');
});
Route::resource('/notes', 'NoteController', ['except' => 'show']);
Route::get('/export', 'NoteController@export')->name('export');
Route::get('/import', 'NoteController@import')->name('import');
