<?php

Route::group([

    'namespace'=>'tourOperatorRating',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorRating',  'as' => 'tourOperatorRating.'], function() {
        Route::post('/store', 'tourOperatorRatingController@store')->name('store');
    });




});
