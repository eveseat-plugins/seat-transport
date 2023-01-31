<?php

Route::group([
    'namespace'  => 'RecursiveTree\Seat\TransportPlugin\Http\Controllers',
    'middleware' => ['web', 'auth'],
    'prefix' => 'transport',
], function () {
    Route::get('/settings', [
        'as'   => 'transportplugin.settings',
        'uses' => 'TransportPluginController@settings',
        'middleware' => 'can:transportplugin.settings'
    ]);

    Route::post('/settings', [
        'as'   => 'transportplugin.saveSettings',
        'uses' => 'TransportPluginController@saveSettings',
        'middleware' => 'can:transportplugin.settings'
    ]);

    Route::post('/settings/deleteroute', [
        'as'   => 'transportplugin.deleteRoute',
        'uses' => 'TransportPluginController@deleteRoute',
        'middleware' => 'can:transportplugin.settings'
    ]);

    Route::get('/calculate', [
        'as'   => 'transportplugin.calculate',
        'uses' => 'TransportPluginController@calculate',
        'middleware' => 'can:transportplugin.calculate'
    ]);

    Route::post('/calculate', [
        'as'   => 'transportplugin.submitCalculate',
        'uses' => 'TransportPluginController@postCalculate',
        'middleware' => 'can:transportplugin.calculate'
    ]);
});