<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\FixtureController;
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

Route::middleware(['auth:sanctum', 'cors'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/{user:id}/balance', [BalanceController::class, 'store'])->middleware('token');
Route::get('/users/{user:id}/balance', [BalanceController::class, 'index'])->middleware('token');

Route::post('/fixtures', [FixtureController::class, 'store']);
Route::get('/fixtures', [FixtureController::class, 'index']);

require __DIR__.'/auth.php';