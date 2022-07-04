<?php

use App\Http\Controllers\Auth\AuthenticateUserController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\BetslipCartController;
use App\Http\Controllers\BetslipController;
use App\Http\Controllers\BetslipHistoryController;
use App\Http\Controllers\CheckoutCartController;
use App\Http\Controllers\CustomFixtureController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\OddController;
use App\Http\Controllers\SocialShareButtonsController;
use App\Http\Controllers\SupportController;
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

Route::middleware(['cors'])->get('/user', [AuthenticateUserController::class, 'show']);
Route::middleware(['cors'])->get('/users/auth_user', [AuthenticateUserController::class, 'index']);


Route::post('/users/{user:id}/balance', [BalanceController::class, 'store'])->middleware('token');
Route::get('/users/balance', [BalanceController::class, 'index'])->middleware('token');
Route::get('/users/{user:id}/balance/deposits', [BalanceController::class, 'deposits'])->middleware('token');
Route::get('/users/{user:id}/balance/history', [BalanceController::class, 'show'])->middleware('token');

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
// Route::get('/checkouts/users/{user:id}/sessions/{session_id}', [CheckoutCartController::class, 'show']);

// Betslip History Controllers
Route::get('/users/{user:id}/betslips', [BetslipHistoryController::class, 'show']);
Route::get('/users/betslips/status', [BetslipHistoryController::class, 'index']);
Route::get('users/sessions/{session_id}/history', [BetslipHistoryController::class, 'get_fixture']);
Route::get('/users/betslips/search', [BetslipHistoryController::class, 'search_date']);
Route::patch('/users/betslips/update', [BetslipHistoryController::class, 'update']);
Route::delete('/users/betslips/delete', [BetslipHistoryController::class, 'delete']);

// Social share URI
Route::get('/social-share', [SocialShareButtonsController::class, 'index']);

// Customer Care Message
Route::post('/support', [SupportController::class, 'store']);

// Custom Fixture
Route::get('/custom_fixture', [CustomFixtureController::class, 'fixture']);
Route::get('/custom_fixture/{fixture_id}', [CustomFixtureController::class, 'show']);
Route::get('/fixture/search', [CustomFixtureController::class, 'search']);
Route::post('/custom_fixture/post', [CustomFixtureController::class, 'post_fixture']);
Route::post('/custom_fixture/odds', [CustomFixtureController::class, 'post_odds']);

require __DIR__.'/auth.php';