<?php

use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Broker\BrokerController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Commission\CommissionController;
use App\Http\Controllers\CommissionPaid\CommissionPaidController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Events\EventsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Libraries\LibBlock\LibBlockController;
use App\Http\Controllers\Libraries\LibLot\LibLotController;
use App\Http\Controllers\Libraries\LibSection\LibSectionController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Permissions\Permission\PermissionController;
use App\Http\Controllers\Teams\TeamsController;
use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\Users\Users\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/refresh_', function () {
    Artisan::call('cache:forget spatie.permission.cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    // Artisan::call('config:cache');
    // Artisan::call('route:cache');
    return "DONE";
});

Route::get('/', function () {
    // $user = User::find(1);
    // Auth::login($user);
    if (Auth::check()) {
        return redirect('/dashboard/regular');
    } else {
        return view('login');
    }
});

Route::post('/login_user', [HomeController::class, 'login']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/{game_category}', [DashboardController::class, 'index']);
    Route::get('/per-event', [DashboardController::class, 'per_event']);
    Route::get('/settings', [DashboardController::class, 'settings']);
    Route::get('/print/sub/{sub_category_id}', [DashboardController::class, 'print_sub_category']);
    Route::get('/print/certificate/{sub_category_id}', [DashboardController::class, 'print_certificate']);
    Route::get('/print/category/{category_id}', [DashboardController::class, 'print_category']);
    Route::get('/print/event/{event_id}', [DashboardController::class, 'print_event']);
    Route::get('/print-final', [DashboardController::class, 'print_final']);
    Route::get('/print/team/{team_id}', [DashboardController::class, 'print_team']);
    Route::get('/winners/team/{team_id}', [DashboardController::class, 'winners_per_team']);
    Route::get('/print-winners/{team_id}', [DashboardController::class, 'print_winners']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/commissions', [CommissionController::class, 'index']);
    Route::post('/commission/get_commissions', [CommissionController::class, 'get_commissions']);
});


//Teams
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('teams', [TeamsController::class, 'index']);
    Route::post('tbl-team/save_tbl_team', [TeamsController::class, 'save_tbl_team']);
    Route::get('/tbl-team/get_tbl_teams', [TeamsController::class, 'get_tbl_teams']);
    Route::post('/tbl-team/delete_tbl_team', [TeamsController::class, 'delete_tbl_team']);
    Route::get('/tbl-team/get_ajax_data_tbl_team', [TeamsController::class, 'get_ajax_data_tbl_team']);
});

//Events
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('events', [EventsController::class, 'index']);
    Route::post('event/save_tbl_event', [EventsController::class, 'save_tbl_event']);
    Route::post('event/save_tbl_event_category', [EventsController::class, 'save_tbl_event_category']);
    Route::get('/event/get_tbl_events', [EventsController::class, 'get_tbl_events']);
    Route::post('/event/delete_tbl_event', [EventsController::class, 'delete_tbl_event']);
    Route::get('/event/get_ajax_data_tbl_event', [EventsController::class, 'get_ajax_data_tbl_event']);
    Route::get('/event/view/{id}', [EventsController::class, 'view_event']);
    Route::post('/event/delete_event_category', [EventsController::class, 'delete_event_category']);
    Route::post('/event/save_tbl_event_sub_category', [EventsController::class, 'save_tbl_event_sub_category']);
    Route::post('/event/delete_event_sub_category', [EventsController::class, 'delete_event_sub_category']);
    Route::post('/event/save_score', [EventsController::class, 'save_score']);
    Route::post('/event/get_score', [EventsController::class, 'get_score']);
    Route::post('/event/validate_score', [EventsController::class, 'validate_score']);
    Route::post('/event/invalidate_score', [EventsController::class, 'invalidate_score']);
    Route::post('/event/delete_score', [EventsController::class, 'delete_score']);
});

//Users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user', [UsersController::class, 'index']);
    Route::post('user/save_user', [UsersController::class, 'save_user']);
    Route::get('/user/get_users', [UsersController::class, 'get_users']);
    Route::post('/user/delete_user', [UsersController::class, 'delete_user']);
    Route::get('/user/get_ajax_data_user', [UsersController::class, 'get_ajax_data_user']);
    Route::post('/user/save_permissions', [UsersController::class, 'save_permissions']);
    Route::post('/user/save_user', [UsersController::class, 'save_user']);
});

//Permission
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('permissions', [PermissionController::class, 'index']);
    Route::post('permission/save_permission', [PermissionController::class, 'save_permission']);
    Route::get('/permission/get_permissions', [PermissionController::class, 'get_permissions']);
    Route::post('/permission/delete_permission', [PermissionController::class, 'delete_permission']);
    Route::get('/permission/get_ajax_data_permission', [PermissionController::class, 'get_ajax_data_permission']);
});



//GOOGLE LOGIN
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// FACEBOOK LOGIN
Route::get('auth/facebook', [FacebookController::class, 'handleFacebookRedirect']);
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);


require __DIR__ . '/auth.php';
