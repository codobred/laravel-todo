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
Route::match(['get', 'post'], '/export', 'ExportController@export')->name('export');
Route::get('/import', 'ImportController@index')->name('import');
Route::post('/import', 'ImportController@import')->name('import');

// delete note image
Route::post('/ajax/delete-image', 'NoteController@deleteImage')->name('ajax.delete-image');
