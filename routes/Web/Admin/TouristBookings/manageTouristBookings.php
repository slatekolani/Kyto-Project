<?php

Route::group([

    'namespace'=>'touristBookings',

] ,function () {

    Route::group([ 'prefix' => 'touristBookings',  'as' => 'touristBookings.'], function() {
        Route::get('/create/{tour_operator}','touristBookingsController@create')->name('create');
        Route::post('/store','touristBookingsController@store')->name('store');
        Route::get('/show','touristBookingsController@show')->name('show');
        Route::get('/get_bookings/{tour_operator}','touristBookingsController@get_bookings')->name('get_bookings');
        Route::get('/index/{tour_operator}','touristBookingsController@index')->name('index');
        Route::get('/edit/{tourist_bookings}','touristBookingsController@edit')->name('edit');
        Route::put('/update/{tourist_bookings}','touristBookingsController@update')->name('update');
        Route::get('/delete/{tourist_bookings}','touristBookingsController@destroy')->name('delete');
        Route::get('/ConfirmationStatus','touristBookingsController@ConfirmationStatus')->name('ConfirmationStatus');
        Route::get('/overview/{tour_operator}','touristBookingsController@overview')->name('overview');
        Route::get('/get_recent_bookings/{tour_operator}','touristBookingsController@get_recent_bookings')->name('get_recent_bookings');
        Route::get('/getVerifiedTrips/{tour_operator}','touristBookingsController@getVerifiedTrips')->name('getVerifiedTrips');
        Route::get('/recent_bookings_index/{tour_operator}','touristBookingsController@recent_bookings_index')->name('recent_bookings_index');
        Route::get('/verifiedTripsIndex/{tour_operator}','touristBookingsController@verifiedTripsIndex')->name('verifiedTripsIndex');
        Route::get('/unverifiedTripsIndex/{tour_operator}','touristBookingsController@unverifiedTripsIndex')->name('unverifiedTripsIndex');
        Route::get('/recent_trips_to_be_conducted_index/{tour_operator}','touristBookingsController@recent_trips_to_be_conducted_index')->name('recent_trips_to_be_conducted_index');
        Route::get('/get_recent_trips_to_be_conducted/{tour_operator}','touristBookingsController@get_recent_trips_to_be_conducted')->name('get_recent_trips_to_be_conducted');
        Route::get('/getUnverifiedTrips/{tour_operator}','touristBookingsController@getUnverifiedTrips')->name('getUnverifiedTrips');
        Route::get('/search_Trip_booked','touristBookingsController@search_Trip_booked')->name('search_Trip_booked');
    });




});
