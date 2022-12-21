<?php

Route::group([

    'namespace'=>'Payments\soloBookingsPayments',

] ,function () {

    Route::group([ 'prefix' => 'soloBookingsPayments',  'as' => 'soloBookingsPayments.'], function() {
//        Route::get('/index/{tourist_booking}', 'soloBookingPaymentsController@index')->name('index');
        Route::get('/create/{solo_bookings}', 'soloBookingPaymentsController@create')->name('create');
        Route::post('/store', 'soloBookingPaymentsController@store')->name('store');
        Route::get('/show/{solo_bookings}','soloBookingPaymentsController@show')->name('show');
//        Route::get('/get_payments/{tourist_booking}','paymentsController@get_payments')->name('get_payments');
//        Route::get('/edit/{booking_payments}','paymentsController@edit')->name('edit');
//        Route::put('/update/{booking_payments}','paymentsController@update')->name('update');
//        Route::get('/delete/{booking_payments}','paymentsController@destroy')->name('delete');
//        Route::get('/changePaymentStatus','paymentsController@changePaymentStatus')->name('changePaymentStatus');
//        Route::get('/get_recent_payments/{tourist_booking}','paymentsController@get_recent_payments')->name('get_recent_payments');
//        Route::get('/recent_payments_index/{tourist_booking}','paymentsController@recent_payments_index')->name('recent_payments_index');
    });




});
