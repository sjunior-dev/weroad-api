<?php

use App\Http\Controllers\TourController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TravelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')
    ->get('/user', function (Request $request) {
        return $request->user();
    });

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('test-admin', function () {
        // If the Content-Type and Accept headers are set to 'application/json',
        // this will return a JSON structure. This will be cleaned up later.
        return ['Test Route Admin WeRoad API'];
    })->middleware('roles:admin');
    Route::get('test-editor', function () {
        // If the Content-Type and Accept headers are set to 'application/json',
        // this will return a JSON structure. This will be cleaned up later.
        return ['Test Route Editor WeRoad API'];
    })->middleware('roles:editor');

    Route::get('travels', [TravelController::class, 'index'])->middleware('roles:admin');
    Route::post('travel', [TravelController::class, 'store'])->middleware('roles:admin');

    // ADMIN CREATE
    Route::get('travel/{travel:uuid}/tours', [TourController::class, 'index'])->middleware('roles:admin');
    Route::post('travel/{travel:uuid}/tour', [TourController::class, 'store'])->middleware('roles:admin');

    // EDITOR UPDATE
    Route::put('tour/{tour:uuid}', [TourController::class, 'update'])->middleware('roles:editor');
});

// SEARCH
Route::get('search/{travel:slug}', [SearchController::class, 'index']);

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
