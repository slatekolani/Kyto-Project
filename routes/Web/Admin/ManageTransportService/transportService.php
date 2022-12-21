<?php

Route::group([

    'namespace'=>'transportService',

] ,function () {

    Route::group([ 'prefix' => 'transportService',  'as' => 'transportService.'], function() {
        Route::get('/index', 'transportServiceController@index')->name('index');
        Route::get('/create', 'transportServiceController@create')->name('create');
        Route::get('/get_transport_service', 'transportServiceController@get_transport_service')->name('get_transport_service');
        Route::post('/store', 'transportServiceController@store')->name('store');
        Route::get('/edit/{transport_service}', 'transportServiceController@edit')->name('edit');
        Route::put('/update/{transport_service}', 'transportServiceController@update')->name('update');
        Route::get('/delete/{transport_service}', 'transportServiceController@destroy')->name('delete');
        Route::get('/activateTransport', 'transportServiceController@activateTransport')->name('activateTransport');
    });




});
