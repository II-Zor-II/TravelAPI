<?php

use App\Http\Controllers\v1\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\Admin\TravelController as AdminTravelController;
use App\Http\Controllers\v1\Admin\TourController as AdminTourController;
use App\Http\Controllers\v1\TravelController;
use App\Http\Controllers\v1\TourController;
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

Route::get('travels', [TravelController::class, 'index']);
Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);

Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::post('travels', [AdminTravelController::class, 'store']);
        Route::post('travels/{travel}/tours', [AdminTourController::class, 'store']);
    });

    // Route::put('travels/{travel}', [TravelController::class, 'update']);
});

Route::prefix('auth')->group(function(){
    Route::post('login', LoginController::class);
});

