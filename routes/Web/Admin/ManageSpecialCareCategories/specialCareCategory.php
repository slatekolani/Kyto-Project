<?php

Route::group([

    'namespace'=>'specialCare',

] ,function () {

    Route::group([ 'prefix' => 'specialCare',  'as' => 'specialCare.'], function() {
        Route::get('/index', 'specialCareController@index')->name('index');
        Route::get('/create', 'specialCareController@create')->name('create');
        Route::get('/get_special_care', 'specialCareController@get_special_care')->name('get_special_care');
        Route::post('/store', 'specialCareController@store')->name('store');
        Route::get('/edit/{special_care_category}', 'specialCareController@edit')->name('edit');
        Route::put('/update/{special_care_category}', 'specialCareController@update')->name('update');
        Route::get('/delete/{special_care_category}', 'specialCareController@destroy')->name('delete');
        Route::get('/activateSpecialCare', 'specialCareController@activateSpecialCare')->name('activateSpecialCare');
    });




});
