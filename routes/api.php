<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => ['ipcheck'],
], function ($app) {
    $app->get('properties', 'PropertyController@index');
    $app->get('reviews', 'ReviewController@lists');
    $app->get('review/{id}', 'ReviewController@index');
    $app->post('review/create', 'ReviewController@store');
});
