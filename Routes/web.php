<?php

Route::prefix('auto-attendant-builder')->name('AutoAttendantBuilderModule.')->group(function() {
    Route::get(   '/',            'AutoAttendantBuilderModuleController@index')  ->name('index');
    Route::post(  '/',            'AutoAttendantBuilderModuleController@store')  ->name('store');

    Route::get(   'wizard',       'WizardController@index')                      ->name('wizard');
    Route::get(   'create',       'AutoAttendantBuilderModuleController@create') ->name('create');
    Route::get('tips-and-tricks', 'TipsController@index')                        ->name('tips');
    Route::get('load-data-file',  'LoadDataController@index')                    ->name('loadData');

    Route::get(   '{uuid}',       'AutoAttendantBuilderModuleController@show')   ->name('show');
    Route::get(   '{uuid}/edit',  'AutoAttendantBuilderModuleController@edit')   ->name('edit');
    Route::put(   '{uuid}/edit',  'AutoAttendantBuilderModuleController@update') ->name('update');
    Route::delete('{uuid}',       'AutoAttendantBuilderModuleController@destroy')->name('destroy');

});
