<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  ['middleware' => 'guest', function()
{
    return view('auth.login');
}]);


Auth::routes(['register' => false]);
Route::group([
    'middleware' => ['auth'],
], function ($app) {

    $app->get('/home', 'HomeController@index')->name('home');
    $app->get('/websites', 'HomeController@websites')->name('websites');
    $app->get('/websites/info', 'HomeController@websitesInfo')->name('websites.info');

    $app->get('reviews', 'ReviewController@lists');
    $app->get('review/{id}', 'ReviewController@index');
    $app->post('review/create', 'ReviewController@store');

    $app->post('review/{id}/approve', 'ReviewController@approve');
    $app->post('review/{id}/reject', 'ReviewController@reject');

    $app->post('review/approve/bundle', 'ReviewController@approveBundle');

    $app->post('review/{id}/mark-as-relevant', 'ReviewController@relevant');
    $app->post('review/{id}/mark-as-unrelevant', 'ReviewController@unrelevant');

 
});