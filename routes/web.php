<?php

Route::get('/', 'DomainController@index')->name('home');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');
Route::get('/support', 'HomeController@support')->name('support');
Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/favorites', 'UserController@favorites')->name('favorites');
Route::get('/{name}', 'DomainController@show')->name('domain');
Route::get('/login/redirect', 'SocialAuthFacebookController@redirect')->name('redirect');
Route::get('/login/callback', 'SocialAuthFacebookController@callback')->name('callback');
Route::post('/favorite/{domain}', 'UserController@favorite')->name('favorite');
Route::post('/unfavorite/{domain}', 'UserController@unfavorite')->name('unfavorite');

Auth::routes();
