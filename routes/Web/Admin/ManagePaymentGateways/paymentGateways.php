<?php

Route::group([

    'namespace'=>'paymentGateways',

] ,function () {

    Route::group([ 'prefix' => 'paymentGateway',  'as' => 'paymentGateway.'], function() {
        Route::get('/index', 'paymentGatewayController@index')->name('index');
        Route::get('/create', 'paymentGatewayController@create')->name('create');
        Route::get('/get_payment_gateways', 'paymentGatewayController@get_payment_gateways')->name('get_payment_gateways');
        Route::post('/store', 'paymentGatewayController@store')->name('store');
        Route::get('/edit/{payment_gateway}', 'paymentGatewayController@edit')->name('edit');
        Route::put('/update/{payment_gateway}', 'paymentGatewayController@update')->name('update');
        Route::get('/delete/{payment_gateway}', 'paymentGatewayController@destroy')->name('delete');
        Route::get('/activateGateway', 'paymentGatewayController@activateGateway')->name('activateGateway');
    });




});
