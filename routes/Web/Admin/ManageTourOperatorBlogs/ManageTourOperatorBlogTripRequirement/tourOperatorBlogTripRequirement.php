<?php

Route::group([

    'namespace'=>'tourOperatorBlogs',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorBlogTripRequirement',  'as' => 'tourOperatorBlogTripRequirement.'], function() {
        Route::get('/index/{tour_operator_blog}', 'tourOperatorBlogTripRequirementController@index')->name('index');
        Route::get('/get_trip_requirement/{tour_operator_blog}', 'tourOperatorBlogTripRequirementController@get_trip_requirement')->name('get_trip_requirement');
    });




});
