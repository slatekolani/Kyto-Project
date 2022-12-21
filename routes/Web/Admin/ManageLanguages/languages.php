<?php

Route::group([

    'namespace'=>'Language',

] ,function () {

    Route::group([ 'prefix' => 'Language',  'as' => 'Language.'], function() {
        Route::get('/index', 'LanguageController@index')->name('index');
        Route::get('/create', 'LanguageController@create')->name('create');
        Route::get('/get_language', 'LanguageController@get_language')->name('get_language');
        Route::post('/store', 'LanguageController@store')->name('store');
        Route::get('/edit/{language}', 'LanguageController@edit')->name('edit');
        Route::put('/update/{language}', 'LanguageController@update')->name('update');
        Route::get('/delete/{language}', 'LanguageController@destroy')->name('delete');
        Route::get('/activateLanguage', 'LanguageController@activateLanguage')->name('activateLanguage');
    });




});
