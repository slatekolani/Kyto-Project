<?php

Route::group([

    'namespace'=>'touristBookings\soloBookings',

] ,function () {

    Route::group([ 'prefix' => 'soloBookings',  'as' => 'soloBookings.'], function() {
        Route::get('/index/{tour_operator}', 'soloBookingsController@index')->name('index');
        Route::get('/verifiedTripsIndex/{tour_operator}', 'soloBookingsController@verifiedTripsIndex')->name('verifiedTripsIndex');
        Route::get('/unverifiedTripsIndex/{tour_operator}', 'soloBookingsController@unverifiedTripsIndex')->name('unverifiedTripsIndex');
        Route::get('/recentTripsToBeConductedIndex/{tour_operator}', 'soloBookingsController@recentTripsToBeConductedIndex')->name('recentTripsToBeConductedIndex');
        Route::get('/recentSoloTripsBookingsIndex/{tour_operator}', 'soloBookingsController@recentSoloTripsBookingsIndex')->name('recentSoloTripsBookingsIndex');
        Route::get('/create/{tour_operator}', 'soloBookingsController@create')->name('create');
        Route::get('/setSoloTripAmount/{solo_booking}', 'soloBookingsController@setSoloTripAmount')->name('setSoloTripAmount');
        Route::get('/get_solo_bookings/{tour_operator}','soloBookingsController@get_solo_bookings')->name('get_solo_bookings');
        Route::get('/get_verified_solo_trips/{tour_operator}','soloBookingsController@get_verified_solo_trips')->name('get_verified_solo_trips');
        Route::get('/get_unverified_solo_trips/{tour_operator}','soloBookingsController@get_unverified_solo_trips')->name('get_unverified_solo_trips');
        Route::get('/get_recent_solo_trips_to_be_conducted/{tour_operator}','soloBookingsController@get_recent_solo_trips_to_be_conducted')->name('get_recent_solo_trips_to_be_conducted');
        Route::get('/get_recent_solo_trip_bookings/{tour_operator}','soloBookingsController@get_recent_solo_trip_bookings')->name('get_recent_solo_trip_bookings');
        Route::get('/overview/{tour_operator}','soloBookingsController@overview')->name('overview');
        Route::post('/store', 'soloBookingsController@store')->name('store');
        Route::post('/storeSoloTripAmount', 'soloBookingsController@storeSoloTripAmount')->name('storeSoloTripAmount');
        Route::get('/show', 'soloBookingsController@show')->name('show');
        Route::get('/search_Trip_booked_solo', 'soloBookingsController@search_Trip_booked_solo')->name('search_Trip_booked_solo');
        Route::get('/edit/{solo_booking}', 'soloBookingsController@edit')->name('edit');
        Route::put('/update/{solo_booking}', 'soloBookingsController@update')->name('update');
        Route::get('/ConfirmationStatus', 'soloBookingsController@ConfirmationStatus')->name('ConfirmationStatus');
        Route::get('/PublicOrPrivateTripStatus', 'soloBookingsController@PublicOrPrivateTripStatus')->name('PublicOrPrivateTripStatus');
        Route::get('/delete/{solo_booking}', 'soloBookingsController@destroy')->name('delete');
    });




});
