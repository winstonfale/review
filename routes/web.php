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

    $app->get('/comments', 'HomeController@comments')->name('comments');
    
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

    $app->get('clicks', 'ClickController@index')->name('clicks');
    $app->post('clicks', 'ClickController@indexData');
    $app->get('overall', 'ClickController@overall');

    $app->get('campaigns', 'CampaignController@index')->name('campaigns');
    $app->post('campaigns', 'CampaignController@data');

    $app->get('dashboard', 'HomeController@index')->name('dashboard');
    $app->post('dashboard', 'HomeController@dashboard')->name('home');


    $app->get('costs', 'CostController@index')->name('costs');
    $app->post('costs', 'CostController@data');
    $app->post('cost/store', 'CostController@store');
    $app->post('cost/{id}/delete', 'CostController@delete');

    $app->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function() use ($app) {
        $app->get('logs', 'LogViewerController@index');
    });

 
});

