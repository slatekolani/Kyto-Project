<?php

Route::group([

    'namespace'=>'touristBookings\soloBookings',

] ,function () {

    Route::group([ 'prefix' => 'soloBookingTripPals',  'as' => 'soloBookingTripPals.'], function() {
        Route::get('/create/{solo_booking}', 'soloBookingTripPalsController@create')->name('create');
        Route::post('/store', 'soloBookingTripPalsController@store')->name('store');
        Route::get('/show/{solo_booking}', 'soloBookingTripPalsController@show')->name('show');
//        Route::get('/search_Trip_booked_solo', 'soloBookingsController@search_Trip_booked_solo')->name('search_Trip_booked_solo');
    });




});
