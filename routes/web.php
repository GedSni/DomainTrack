<?php

Route::get('/', 'DomainController@index')->name('home');
Route::get('/{name}', 'DomainController@show')->name('domain');