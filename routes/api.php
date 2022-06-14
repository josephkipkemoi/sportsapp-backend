<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\BetslipCartController;
use App\Http\Controllers\BetslipController;
use App\Http\Controllers\BetslipHistoryController;
use App\Http\Controllers\CheckoutCartController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\OddController;
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

Route::post('/odds', [OddController::class, 'store']);
Route::get('/odds', [OddController::class, 'index']);

// Betslip CRUD
Route::post('/betslips', [BetslipController::class, 'store']);
Route::get('/betslips/{session_id}', [BetslipController::class, 'index']);
Route::delete('/betslips/fixtures/{fixture_id}', [BetslipController::class, 'destroy']);
Route::delete('/betslips/sessions/{session_id}', [BetslipController::class, 'remove']);

// BetslipCart Calculations
Route::get('/betslips/sessions/{session_id}/odds-total', [BetslipCartController::class, 'odds_total']);

// Checkout Controllers
Route::post('/checkout', [CheckoutCartController::class, 'store']);

// Betslip History Controllers
Route::get('/users/{user_id}/betslips', [BetslipHistoryController::class, 'show']);
require __DIR__.'/auth.php';