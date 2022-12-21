<?php

Route::group([

    'namespace'=>'tourOperatorBlogs',

] ,function () {

    Route::group([ 'prefix' => 'tourOperatorBlogs',  'as' => 'tourOperatorBlogs.'], function() {
        Route::get('/create/{tour_operator}', 'tourOperatorBlogsController@create')->name('create');
        Route::get('/index/{tour_operator}', 'tourOperatorBlogsController@index')->name('index');
        Route::get('/get_tour_operator_blogs/{tour_operator}', 'tourOperatorBlogsController@get_tour_operator_blogs')->name('get_tour_operator_blogs');
        Route::post('/store', 'tourOperatorBlogsController@store')->name('store');
        Route::get('/edit/{tour_operator_blog}', 'tourOperatorBlogsController@edit')->name('edit');
        Route::put('/update/{tour_operator_blog}', 'tourOperatorBlogsController@update')->name('update');
        Route::get('/delete/{tour_operator_blog}', 'tourOperatorBlogsController@destroy')->name('delete');
        Route::get('/enableBlog', 'tourOperatorBlogsController@enableBlog')->name('enableBlog');

    });




});
