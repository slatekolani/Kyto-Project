<?php

Route::group([

    'namespace'=>'tourOperatorProfile',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorProfile',  'as' => 'tourOperatorProfile.'], function() {
        Route::get('/create/{tour_operator}', 'tourOperatorProfileController@create')->name('create');
        Route::post('/store', 'tourOperatorProfileController@store')->name('store');
        Route::get('/edit/{tour_operator}', 'tourOperatorProfileController@edit')->name('edit');
        Route::put('/update/{tour_operator}', 'tourOperatorProfileController@update')->name('update');
    });




});
