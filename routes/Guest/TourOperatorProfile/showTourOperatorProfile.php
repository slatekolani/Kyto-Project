<?php

Route::group([

    'namespace'=>'tourOperatorProfile',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorProfile',  'as' => 'tourOperatorProfile.'], function() {
        Route::get('/index/{tour_operator}', 'tourOperatorProfileController@index')->name('index');
    });




});
