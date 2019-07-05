<?php

use Illuminate\Support\Facades\Route;

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

// Customer APIs
Route::get('customers', 'Api\CustomerController@getCustomers');

// Job Ad APIs
Route::get('job-ads', 'Api\JobAdController@getJobAds');

// Order APIs
Route::post('order/calculate', 'Api\OrderController@calculateTotalPrice');
Route::post('orders', 'Api\OrderController@createOrder');
