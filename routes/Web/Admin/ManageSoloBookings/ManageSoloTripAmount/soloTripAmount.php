<?php

Route::group([

    'namespace'=>'touristBookings\soloBookings',

] ,function () {

    Route::group([ 'prefix' => 'SoloTripAmount',  'as' => 'SoloTripAmount.'], function() {
        Route::get('/index/{solo_booking}', 'SoloTripAmountController@index')->name('index');
        Route::get('/create/{solo_booking}', 'SoloTripAmountController@create')->name('create');
        Route::get('/get_solo_trip_amount/{solo_booking}','SoloTripAmountController@get_solo_trip_amount')->name('get_solo_trip_amount');
        Route::post('/store', 'SoloTripAmountController@store')->name('store');
        Route::get('/edit/{solo_trip_amount}', 'SoloTripAmountController@edit')->name('edit');
        Route::put('/update/{solo_trip_amount}', 'SoloTripAmountController@update')->name('update');
        Route::get('/delete/{solo_trip_amount}', 'SoloTripAmountController@destroy')->name('delete');
    });




});
