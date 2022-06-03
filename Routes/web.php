<?php

Route::prefix('auto-attendant-builder')->name('AutoAttendantBuilderModule.')->group(function() {
    Route::get(   '/',           'AutoAttendantBuilderModuleController@index')  ->name('index');
    Route::get(   'create',      'AutoAttendantBuilderModuleController@create') ->name('create');
    Route::post(  '/',           'AutoAttendantBuilderModuleController@store')  ->name('store');
    Route::get(   '{uuid}',      'AutoAttendantBuilderModuleController@show')   ->name('show');
    Route::get(   '{uuid}/edit', 'AutoAttendantBuilderModuleController@edit')   ->name('edit');
    Route::put(   '{uuid}/edit', 'AutoAttendantBuilderModuleController@update') ->name('update');
    Route::delete('{uuid}',      'AutoAttendantBuilderModuleController@destroy')->name('destroy');
});
