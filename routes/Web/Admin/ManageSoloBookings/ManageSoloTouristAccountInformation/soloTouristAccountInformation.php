<?php

Route::group([

    'namespace'=>'touristBookings\soloBookings',

] ,function () {

    Route::group([ 'prefix' => 'soloTouristAccountInformation',  'as' => 'soloTouristAccountInformation.'], function() {
        Route::get('/create/{solo_booking}', 'soloTouristAccountInformationController@create')->name('create');
        Route::post('/store', 'soloTouristAccountInformationController@store')->name('store');
        Route::get('/show/{solo_booking}', 'soloTouristAccountInformationController@show')->name('show');
        Route::get('/edit/{tourist_account_information}', 'soloTouristAccountInformationController@edit')->name('edit');
        Route::put('/update/{tourist_account_information}', 'soloTouristAccountInformationController@update')->name('update');
        Route::get('/delete/{tourist_account_information}', 'soloTouristAccountInformationController@destroy')->name('delete');
    });




});
