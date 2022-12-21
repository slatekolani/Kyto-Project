<?php

Route::group([

    'namespace'=>'tourOperatorBlogs',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorBlogHoneyPoints',  'as' => 'tourOperatorBlogHoneyPoints.'], function() {
        Route::get('/index/{tour_operator_blog}', 'tourOperatorBlogHoneyPointsController@index')->name('index');
        Route::get('/get_honey_points/{tour_operator_blog}', 'tourOperatorBlogHoneyPointsController@get_honey_points')->name('get_honey_points');
    });




});
