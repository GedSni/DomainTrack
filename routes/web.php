<?php

Route::get('/', 'DomainController@index')->name('home');
Route::get('/privacy', 'DomainController@privacy')->name('privacy');
Route::get('/support', 'DomainController@support')->name('support');
Route::get('/terms', 'DomainController@terms')->name('terms');
Route::get('/favorites', 'DomainController@favorites')->name('favorites');
Route::get('/{name}', 'DomainController@show')->name('domain');
Route::get('/login/redirect', 'SocialAuthFacebookController@redirect')->name('redirect');
Route::get('/login/callback', 'SocialAuthFacebookController@callback')->name('callback');
Route::post('/favorite/{domain}', 'DomainController@favorite')->name('favorite');
Route::post('/unfavorite/{domain}', 'DomainController@unfavorite')->name('unfavorite');

Auth::routes();
