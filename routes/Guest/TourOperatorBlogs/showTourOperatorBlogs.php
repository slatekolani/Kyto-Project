<?php

Route::group([

    'namespace'=>'tourOperatorBlogs',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorBlogs',  'as' => 'tourOperatorBlogs.'], function() {
        Route::get('/view/{tour_operator_blog}','tourOperatorBlogsController@show')->name('view');
        Route::get('/search', 'tourOperatorBlogsController@search')->name('search');

    });




});
