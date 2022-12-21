<?php

Route::group([

    'namespace'=>'touristAttraction',

] ,function () {

    Route::group([ 'prefix' => 'touristAttraction',  'as' => 'touristAttraction.'], function() {
        Route::get('/index', 'touristAttractionController@index')->name('index');
        Route::get('/create', 'touristAttractionController@create')->name('create');
        Route::get('/get_tourist_attractions', 'touristAttractionController@get_tourist_attractions')->name('get_tourist_attractions');
        Route::post('/store', 'touristAttractionController@store')->name('store');
        Route::get('/edit/{tourist_attraction}', 'touristAttractionController@edit')->name('edit');
        Route::put('/update/{tourist_attraction}', 'touristAttractionController@update')->name('update');
        Route::get('/delete/{tourist_attraction}', 'touristAttractionController@destroy')->name('delete');
        Route::get('/activateTouristAttraction', 'touristAttractionController@activateTouristAttraction')->name('activateTouristAttraction');
    });




});
