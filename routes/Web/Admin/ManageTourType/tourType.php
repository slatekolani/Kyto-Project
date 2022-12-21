<?php

Route::group([

    'namespace'=>'tourType',

] ,function () {

    Route::group([ 'prefix' => 'tourType',  'as' => 'tourType.'], function() {
        Route::get('/index', 'tourTypeController@index')->name('index');
        Route::get('/create', 'tourTypeController@create')->name('create');
        Route::get('/get_tour_type', 'tourTypeController@get_tour_type')->name('get_tour_type');
        Route::post('/store', 'tourTypeController@store')->name('store');
        Route::get('/edit/{tour_type}', 'tourTypeController@edit')->name('edit');
        Route::put('/update/{tour_type}', 'tourTypeController@update')->name('update');
        Route::get('/delete/{tour_type}', 'tourTypeController@destroy')->name('delete');
        Route::get('/activateTourType', 'tourTypeController@activateTourType')->name('activateTourType');
    });




});
