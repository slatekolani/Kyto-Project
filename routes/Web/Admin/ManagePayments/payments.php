<?php

Route::group([

    'namespace'=>'Payments',

] ,function () {

    Route::group([ 'prefix' => 'payments',  'as' => 'payments.'], function() {
        Route::get('/index/{tourist_booking}', 'paymentsController@index')->name('index');
        Route::get('/create/{tourist_booking}', 'paymentsController@create')->name('create');
        Route::post('/store', 'paymentsController@store')->name('store');
        Route::get('/show/{tourist_booking}','paymentsController@show')->name('show');
        Route::get('/get_payments/{tourist_booking}','paymentsController@get_payments')->name('get_payments');
        Route::get('/edit/{booking_payments}','paymentsController@edit')->name('edit');
        Route::put('/update/{booking_payments}','paymentsController@update')->name('update');
        Route::get('/delete/{booking_payments}','paymentsController@destroy')->name('delete');
        Route::get('/changePaymentStatus','paymentsController@changePaymentStatus')->name('changePaymentStatus');
        Route::get('/get_recent_payments/{tourist_booking}','paymentsController@get_recent_payments')->name('get_recent_payments');
        Route::get('/recent_payments_index/{tourist_booking}','paymentsController@recent_payments_index')->name('recent_payments_index');
    });




});
