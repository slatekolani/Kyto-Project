<?php

Route::group([

    'namespace'=>'tourOperatorBlogs',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorBlogServices',  'as' => 'tourOperatorBlogServices.'], function() {
        Route::get('/index/{tour_operator_blog}', 'tourOperatorBlogServicesController@index')->name('index');
        Route::get('/get_services/{tour_operator_blog}', 'tourOperatorBlogServicesController@get_services')->name('get_services');
    });




});
