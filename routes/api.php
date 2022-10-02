<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticateUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\BetslipCartController;
use App\Http\Controllers\BetslipController;
use App\Http\Controllers\BetslipHistoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutCartController;
use App\Http\Controllers\CustomFixtureController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\JackpotController;
use App\Http\Controllers\LiveFixturesController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\OddController;
use App\Http\Controllers\RegisteredUserNotificationController;
use App\Http\Controllers\SoccerController;
use App\Http\Controllers\SocialShareButtonsController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TooltipController;
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

// User Account Balance
Route::post('/users/{user:id}/balance', [BalanceController::class, 'store'])->middleware('token');
Route::post('/users/{user:id}/balance/decrement', [BalanceController::class, 'decrement']);
Route::get('/users/balance', [BalanceController::class, 'index'])->middleware('token');
Route::get('/users/{user:id}/balance/deposits', [BalanceController::class, 'deposits'])->middleware('token');
Route::get('/users/{user:id}/balance/history', [BalanceController::class, 'show'])->middleware('token');

// Game Fixtures
Route::post('/fixtures', [FixtureController::class, 'store']);
Route::get('/fixtures', [FixtureController::class, 'index']);

// Generate Fixtures Odds
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
Route::get('users/{user_id}/sessions/{session_id}/history', [BetslipHistoryController::class, 'get_fixture']);
Route::get('/users/betslips/search', [BetslipHistoryController::class, 'search_date']);
Route::patch('/users/betslips/update', [BetslipHistoryController::class, 'update']);
Route::delete('/users/betslips/delete', [BetslipHistoryController::class, 'delete']);

// Social share URI
Route::get('/social-share', [SocialShareButtonsController::class, 'index']);
Route::post('/social-share/codes', [SocialShareButtonsController::class, 'store']);
Route::get('/social-share/codes/show', [SocialShareButtonsController::class, 'show']);

// Customer Care Message
Route::post('/support', [SupportController::class, 'store']);
Route::get('/support/messages', [SupportController::class, 'index']);

// Custom Fixture
Route::get('/custom_fixture', [CustomFixtureController::class, 'fixture']);
Route::get('/custom_fixture/{fixture_id}', [CustomFixtureController::class, 'show']);
Route::get('/fixture/search', [CustomFixtureController::class, 'search']);
Route::post('/custom_fixture/post', [CustomFixtureController::class, 'post_fixture']);
Route::post('/custom_fixture/odds', [CustomFixtureController::class, 'post_odds']);
Route::get('fixtures/ids', [CustomFixtureController::class, 'fixture_ids']);
Route::patch('fixtures/custom_odds/{fixture_id}', [CustomFixtureController::class, 'fixture_odds']);

// Soccer Fixtures
Route::get('/soccer/fixtures', [SoccerController::class, 'index']);

// User Favorites
Route::post('/favorites', [FavoritesController::class, 'store']);
Route::get('/users/{user_id}/favorites', [FavoritesController::class, 'show']);
Route::delete('/users/{user_id}/favorites/remove', [FavoritesController::class, 'remove']);
Route::delete('/users/{user_id}/favorites/{favourite_id}/remove', [FavoritesController::class, 'delete']);

// Mpesa Transactions
Route::get('/mpesa', [MpesaController::class, 'index']);
Route::post('/mpesa/hooks', [MpesaController::class, 'hook']);
Route::post('/mpesa/push', [MpesaController::class, 'push']);
Route::get('/mpesa/auth', [MpesaController::class, 'authMpesa']);
Route::post('/mpesa/insert', [MpesaController::class, 'insert']);

// Cart endpoints
Route::post('/users/fixtures/cart', [CartController::class, 'store']);
Route::get('/users/fixtures/cart/{cart:id}', [CartController::class, 'show']);
Route::get('/users/fixtures/carts', [CartController::class, 'index']);
Route::delete('users/fixtures/carts/delete', [CartController::class, 'delete']);

// Admin Routes
Route::get('/admin/users', [AdminController::class, 'index']);
Route::get('/admin/users/{user_id}/profile', [AdminController::class, 'show']);
Route::patch('/admin/users/{user_id}/bets/{session_id}/update', [AdminController::class, 'update_bethistory']);
Route::patch('/admin/users/{user_id}/balance/update', [AdminController::class, 'update_balance']);
Route::patch('admin/fixture', [AdminController::class, 'custom_fixture']);
Route::get('admin/fixtures/ids', [AdminController::class, 'fixture_ids']);
Route::delete('admin/fixtures/remove', [AdminController::class, 'remove']);
Route::patch('admin/history/updateCartHistory', [AdminController::class, 'update_history_outcome']);
Route::patch('admin/users/updateUser', [AdminController::class, 'update_user']);
Route::post('admin/users/message', [AdminController::class, 'send_message']);

// User Message from Admin/Customer Care
Route::get('users/messages', [AdminController::class, 'message_index']);
Route::get('users/messages/show', [AdminController::class, 'message_show']);

// Jackpot Routes
Route::post('admin/jackpot', [JackpotController::class, 'store']);
Route::post('jackpot/{id}/cart', [JackpotController::class, 'store_cart']);
Route::get('users/jackpot/{id}/history', [JackpotController::class, 'user_index']);
Route::get('jackpot', [JackpotController::class, 'index']);
Route::delete('jackpot/{id}', [JackpotController::class, 'delete']);
Route::delete('admin/jackpot/remove', [JackpotController::class, 'remove']);
Route::patch('admin/jackpot/{id}/patch', [JackpotController::class, 'patch']);
Route::patch('admin/jackpot/{jp_market}/status', [JackpotController::class, 'status']);
Route::post('admin/jackpot/prize', [JackpotController::class, 'jackpot_prize']);
Route::get('jackpot/prize', [JackpotController::class, 'jackpot_index']);

// Live Fixtures Routes
Route::post('fixtures/live', [LiveFixturesController::class, 'store']);
Route::get('fixtures/live', [LiveFixturesController::class, 'index']);

// Tooltip Routes
Route::get('tooltips/status', [TooltipController::class, 'show']);
Route::post('tooltips/users/{user_id}/status/update', [TooltipController::class, 'update']);

// Notification Routes
Route::get('notifications/all/users', [RegisteredUserNotificationController::class, 'all']);
Route::get('notifications/unread/users', [RegisteredUserNotificationController::class, 'index']);
Route::get('notifications/markRead/users', [RegisteredUserNotificationController::class, 'markRead']);

require __DIR__.'/auth.php';