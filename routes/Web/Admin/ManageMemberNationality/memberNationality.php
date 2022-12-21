<?php

Route::group([

    'namespace'=>'MemberNationality',

] ,function () {

    Route::group([ 'prefix' => 'MemberNationality',  'as' => 'MemberNationality.'], function() {
        Route::get('/index', 'MemberNationalityController@index')->name('index');
        Route::get('/create', 'MemberNationalityController@create')->name('create');
        Route::get('/get_member_nationality', 'MemberNationalityController@get_member_nationality')->name('get_member_nationality');
        Route::post('/store', 'MemberNationalityController@store')->name('store');
        Route::get('/edit/{member_nation}', 'MemberNationalityController@edit')->name('edit');
        Route::put('/update/{member_nation}', 'MemberNationalityController@update')->name('update');
        Route::get('/delete/{member_nation}', 'MemberNationalityController@destroy')->name('delete');
        Route::get('/activateNation', 'MemberNationalityController@activateNation')->name('activateNation');
    });




});
