<?php

Route::group([

    'namespace'=>'touristBookings\soloBookings',

] ,function () {

    Route::group([ 'prefix' => 'soloTouristAccountInformation',  'as' => 'soloTouristAccountInformation.'], function() {
        Route::get('/create/{solo_booking}', 'soloTouristAccountInformationController@create')->name('create');
        Route::post('/store', 'soloTouristAccountInformationController@store')->name('store');
        Route::get('/show/{solo_booking}', 'soloTouristAccountInformationController@show')->name('show');
    });




});
