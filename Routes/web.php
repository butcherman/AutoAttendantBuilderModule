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

Route::prefix('auto-attendant-builder')->name('AutoAttendantBuilderModule.')->group(function() {
    Route::get('/', 'AutoAttendantBuilderModuleController@index')->name('index');
});
