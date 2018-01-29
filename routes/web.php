<?php

Route::get('/', 'DomainController@index');
Route::get('/{name}', 'DomainController@show');