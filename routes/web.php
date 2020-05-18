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
// Route Authentication
Route::group(['prefix' => 'backend', 'namespace' => 'BackEnd'], function () {
    // Auth Routes
    Route::get('login', array('as' => 'backend.prelogin',
        'uses' => 'AuthController@displayLoginForm'));
    Route::post('login', array('as' => 'backend.login',
        'uses' => 'AuthController@login'));
    Route::get('logout', array('as' => 'backend.logout',
        'uses' => 'AuthController@logout'));
    Route::any('/', array('as' => 'dashboard', 'uses' => 'DashboardController@index'));
    Route::any('tags', array('as' => 'tags.index', 'uses' => 'TagsController@index'));
    Route::any('organizers', array('as' => 'organizers.index', 'uses' => 'OrganizersController@index'));
    Route::any('events', array('as' => 'events.index', 'uses' => 'EventsController@index'));
    Route::any('users', array('as' => 'users.index', 'uses' => 'UsersController@index'));
    Route::get('settings', array('as' => 'settings.edit', 'uses' => 'SettingsController@edit'));
    Route::put('settings', array('as' => 'settings.update', 'uses' => 'SettingsController@update'));
});
Route::group(['namespace' => 'FrontEnd'], function () {
    Route::get('page/{page}', array('as' => 'homepage.page', 'uses' => 'HomePageController@index'));
    Route::get('/', array('as' => 'homepage', 'uses' => 'HomePageController@index'));
    Route::get('/{event}', array('as' => 'event', 'uses' => 'EventController@index'));
});
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::get('/events/{event}', array('as' => 'events.view', 'uses' => 'EventsController@event'));
    Route::get('/events', array('as' => 'events.index', 'uses' => 'EventsController@index'));
});
