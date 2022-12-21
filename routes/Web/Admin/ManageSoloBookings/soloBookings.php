<?php

Route::group([

    'namespace'=>'touristBookings\soloBookings',

] ,function () {

    Route::group([ 'prefix' => 'soloBookings',  'as' => 'soloBookings.'], function() {
        Route::get('/index/{tour_operator}', 'soloBookingsController@index')->name('index');
        Route::get('/create/{tour_operator}', 'soloBookingsController@create')->name('create');
        Route::get('/get_solo_bookings/{tour_operator}', 'soloBookingsController@get_solo_bookings')->name('get_solo_bookings');
        Route::post('/store', 'soloBookingsController@store')->name('store');
        Route::get('/show', 'soloBookingsController@show')->name('show');
        Route::get('/search_Trip_booked_solo', 'soloBookingsController@search_Trip_booked_solo')->name('search_Trip_booked_solo');
        Route::get('/edit/{solo_booking}', 'soloBookingsController@edit')->name('edit');
        Route::put('/update/{solo_booking}', 'soloBookingsController@update')->name('update');
//        Route::get('/delete/{special_care_category}', 'specialCareController@destroy')->name('delete');
//        Route::get('/activateSpecialCare', 'specialCareController@activateSpecialCare')->name('activateSpecialCare');
    });




});
