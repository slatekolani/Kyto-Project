<?php

Route::group([

    'namespace'=>'Payments\soloBookingsPayments',

] ,function () {

    Route::group([ 'prefix' => 'soloBookingPayments',  'as' => 'soloBookingPayments.'], function() {
        Route::get('/index/{solo_booking}', 'soloBookingPaymentsController@index')->name('index');
        Route::get('/recentSoloTripPaymentsIndex/{tour_operator_id}', 'soloBookingPaymentsController@recentSoloTripPaymentsIndex')->name('recentSoloTripPaymentsIndex');
        Route::get('/verifiedSoloTripPaymentsIndex/{tour_operator_id}', 'soloBookingPaymentsController@verifiedSoloTripPaymentsIndex')->name('verifiedSoloTripPaymentsIndex');
        Route::get('/unverifiedSoloTripPaymentsIndex/{tour_operator_id}', 'soloBookingPaymentsController@unverifiedSoloTripPaymentsIndex')->name('unverifiedSoloTripPaymentsIndex');
        Route::get('/create/{solo_booking}', 'soloBookingPaymentsController@create')->name('create');
        Route::post('/store', 'soloBookingPaymentsController@store')->name('store');
        Route::get('/show/{solo_bookings}','soloBookingPaymentsController@show')->name('show');
        Route::get('/get_solo_payments/{solo_booking}','soloBookingPaymentsController@get_solo_payments')->name('get_solo_payments');
        Route::get('/get_recent_solo_trip_payments/{tour_operator_id}','soloBookingPaymentsController@get_recent_solo_trip_payments')->name('get_recent_solo_trip_payments');
        Route::get('/getVerifiedSoloTripPayments/{tour_operator_id}','soloBookingPaymentsController@getVerifiedSoloTripPayments')->name('getVerifiedSoloTripPayments');
        Route::get('/getUnverifiedSoloTripPayments/{tour_operator_id}','soloBookingPaymentsController@getUnverifiedSoloTripPayments')->name('getUnverifiedSoloTripPayments');
        Route::get('/changePaymentStatus','soloBookingPaymentsController@changePaymentStatus')->name('changePaymentStatus');
        Route::get('/edit/{solo_booking_payment}','soloBookingPaymentsController@edit')->name('edit');
        Route::put('/update/{solo_booking_payment}','soloBookingPaymentsController@update')->name('update');
        Route::get('/delete/{solo_booking_payment}','soloBookingPaymentsController@destroy')->name('delete');
//        Route::get('/delete/{booking_payments}','paymentsController@destroy')->name('delete');
//        Route::get('/changePaymentStatus','paymentsController@changePaymentStatus')->name('changePaymentStatus');
//        Route::get('/get_recent_payments/{tourist_booking}','paymentsController@get_recent_payments')->name('get_recent_payments');
//        Route::get('/recent_payments_index/{tourist_booking}','paymentsController@recent_payments_index')->name('recent_payments_index');
    });




});
