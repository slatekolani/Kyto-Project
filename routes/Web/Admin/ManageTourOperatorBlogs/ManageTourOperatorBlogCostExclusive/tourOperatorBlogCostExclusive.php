<?php

Route::group([

    'namespace'=>'tourOperatorBlogs',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorBlogCostExclusive',  'as' => 'tourOperatorBlogCostExclusive.'], function() {
        Route::get('/index/{tour_operator_blog}', 'tourOperatorBlogCostExclusiveController@index')->name('index');
        Route::get('/get_cost_exclusive/{tour_operator_blog}', 'tourOperatorBlogCostExclusiveController@get_cost_exclusive')->name('get_cost_exclusive');
    });




});
