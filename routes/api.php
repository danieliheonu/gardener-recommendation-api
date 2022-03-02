<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GardenerController;
use App\Http\Controllers\CustomerController;

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

// Unauthenticated endpoints
Route::controller(AuthController::class)->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::get('/logout', 'logout');
    });
});

Route::get('/customers', [CustomerController::class, 'list_of_customers']);
Route::get('/locations', [CustomerController::class, 'list_of_locations']);
Route::get('/gardeners', [GardenerController::class, 'list_of_gardeners']);

// Authenticated endpoints
Route::group(["middleware" => "auth:sanctum"], function(){

    Route::controller(UserController::class)->group(function(){
        Route::prefix('user/{id}')->group(function(){
            Route::put('/update', 'update_user_profile');
            Route::get('/details', 'retrieve_user_profile');
        });
    });

    Route::controller(GardenerController::class)->group(function(){
        Route::prefix('gardener')->group(function(){
            Route::get('{id}/details', 'retrieve_a_gardener');
            Route::post('/register', 'register_gardener');
            Route::put('{id}/update', 'update_a_gardener');
            Route::delete('{id}/delete', 'remove_gardener');
        });
    });

    Route::controller(CustomerController::class)->group(function(){
        Route::prefix('customer')->group(function(){
            Route::get('{id}/details', 'retrieve_a_customer');
            Route::post('/register', 'create_a_customer');
            Route::put('{id}/update', 'update_a_customer');
            Route::delete('{id}/delete', 'remove_customer');
        });
    });
});
