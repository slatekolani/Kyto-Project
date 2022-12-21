<?php

Route::group([

    'namespace'=>'tourOperatorAccounts',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorAccounts',  'as' => 'tourOperatorAccounts.'], function() {
        Route::get('/index/{tour_operator}', 'tourOperatorAccountsController@index')->name('index');
        Route::get('/create/{tour_operator}', 'tourOperatorAccountsController@create')->name('create');
        Route::get('/get_tour_operator_account/{tour_operator}', 'tourOperatorAccountsController@get_tour_operator_account')->name('get_tour_operator_account');
        Route::post('/store', 'tourOperatorAccountsController@store')->name('store');
        Route::get('/edit/{tour_operator_account}', 'tourOperatorAccountsController@edit')->name('edit');
        Route::put('/update/{tour_operator_account}', 'tourOperatorAccountsController@update')->name('update');
        Route::get('/delete/{tour_operator_account}', 'tourOperatorAccountsController@destroy')->name('delete');
        Route::get('/activateAccount', 'tourOperatorAccountsController@activateAccount')->name('activateAccount');
    });




});
