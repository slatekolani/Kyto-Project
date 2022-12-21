<?php

Route::group([

    'namespace'=>'tourOperatorBlogs',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorBlogCostInclusive',  'as' => 'tourOperatorBlogCostInclusive.'], function() {
        Route::get('/index/{tour_operator_blog}', 'tourOperatorBlogCostInclusiveController@index')->name('index');
        Route::get('/get_cost_inclusive/{tour_operator_blog}', 'tourOperatorBlogCostInclusiveController@get_cost_inclusive')->name('get_cost_inclusive');
    });




});
