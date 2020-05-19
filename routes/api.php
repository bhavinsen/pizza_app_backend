<?php

use Illuminate\Http\Request;
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

Route::group(['prefix' => 'auth'], function (){

    Route::post('login', 'AuthController@login')->name('login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function() {
       Route::get('logout', 'AuthController@logout');
    });
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('/products', 'ProductController');
Route::apiResource('/carts', 'CartController')->except(['update', 'index']);
Route::apiResource('/orders', 'OrderController')->except(['update', 'destroy', 'store'])->middleware('auth:api');
Route::apiResource('/cartitems', 'CartItemController')->except(['update', 'index', 'show', 'store']);
Route::post('carts/{cart}', 'CartController@addProduct');
Route::post('carts/{cart}/checkout', 'CartController@checkout');