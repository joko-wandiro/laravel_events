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
//    Route::get('pos', array('as' => 'orders.create', 'uses' => 'PosController@create'));
//    Route::post('pos', array('as' => 'orders.store', 'uses' => 'PosController@store'));
//    Route::get('pos/{id_order}', array('as' => 'orders.show', 'uses' => 'PosController@show'));
//    Route::get('pos/{id_order}/edit', array('as' => 'orders.edit', 'uses' => 'PosController@edit'));
//    Route::put('pos/{id_order}', array('as' => 'orders.update', 'uses' => 'PosController@update'));
//    Route::any('orders', array('as' => 'orders.index', 'uses' => 'OrdersController@index'));
//    Route::get('reports/daily/{year}/{month}', array('as' => 'orders.show', 'uses' => 'ReportsController@daily'));
//    Route::get('reports/monthly/{year}', array('as' => 'orders.show', 'uses' => 'ReportsController@monthly'));
//    Route::any('customers', array('as' => 'customers.index', 'uses' => 'CustomersController@index'));
});
Route::group(['namespace' => 'FrontEnd'], function () {
    Route::get('/{event}', array('as' => 'event', 'uses' => 'EventController@index'));
    Route::get('page/{page}', array('as' => 'homepage.page', 'uses' => 'HomePageController@index'));
    Route::get('/', array('as' => 'homepage', 'uses' => 'HomePageController@index'));
    
//    Route::get('category/{category}', array('as' => 'category', 'uses' => 'CategoryController@index'));
//    Route::get('product/{product}', array('as' => 'product', 'uses' => 'ProductController@index'));
//    Route::post('product/add', array('as' => 'product', 'uses' => 'ProductController@add'));
//    Route::get('cart', array('as' => 'cart.index', 'uses' => 'CartController@index'));
//    Route::post('cart/add', array('as' => 'cart.add', 'uses' => 'CartController@add'));
//    Route::get('delivery-info', array('as' => 'deliveryinfo.index', 'uses' => 'DeliveryInfoController@index'));
//    Route::post('delivery-info/save', array('as' => 'deliveryinfo.save', 'uses' => 'DeliveryInfoController@save'));
//    Route::get('payment', array('as' => 'payment.index', 'uses' => 'PaymentController@index'));
//    Route::post('payment/save', array('as' => 'payment.save', 'uses' => 'PaymentController@save'));
//    Route::get('order/{id_order}', array('as' => 'order.index', 'uses' => 'OrderController@index'));
    
//    Route::any('delivery-info', array('as' => 'deliveryinfo.index', 'uses' => 'DeliveryInfoController@index'));
//    Route::get('rss', array('as' => 'rss', 'uses' => 'BlogController@rss'));
//    Route::get('category/{category}/page/{page}', array('as' => 'category', 'uses' => 'BlogController@category'));
//    Route::get('search/{search}', array('as' => 'search', 'uses' => 'BlogController@search'));
//    Route::get('search/{search}/page/{page}', array('as' => 'search', 'uses' => 'BlogController@search'));
//    Route::get('tag/{tag}', array('as' => 'tag', 'uses' => 'BlogController@tag'));
//    Route::get('tag/{tag}/page/{page}', array('as' => 'tag', 'uses' => 'BlogController@tag'));
//    Route::get('{page}/page/{number}', array('as' => 'blog', 'uses' => 'BlogController@page'));
//    Route::get('{page}', array('as' => 'page', 'uses' => 'BlogController@page'));
//    Route::post('{page}', array('as' => 'page', 'uses' => 'BlogController@page'));
//    Route::get('{page}/{post}', array('as' => 'post', 'uses' => 'BlogController@single'));
//    Route::post('{page}/{post}', array('as' => 'post', 'uses' => 'BlogController@single'));
});
