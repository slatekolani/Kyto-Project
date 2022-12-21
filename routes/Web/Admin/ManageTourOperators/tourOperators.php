<?php

Route::group([

    'namespace'=>'tourOperators',

] ,function () {

    Route::group([ 'prefix' => 'tourOperator',  'as' => 'tourOperator.'], function() {
        Route::get('/create', 'tourOperatorController@create')->name('create');
        Route::post('/store', 'tourOperatorController@store')->name('store');
        Route::get('/get_tour_operator','tourOperatorController@get_tour_operator')->name('get_tour_operator');
        Route::get('/index','tourOperatorController@index')->name('index');
        Route::get('/edit/{tour_operator}','tourOperatorController@edit')->name('edit');
        Route::put('/update/{tour_operator}','tourOperatorController@update')->name('update');
        Route::get('/delete/{tour_operator}','tourOperatorController@destroy')->name('delete');
        Route::get('/activateCompanyStatus','tourOperatorController@activateCompanyStatus')->name('activateCompanyStatus');
    });




});
