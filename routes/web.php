<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard.index');
// });

Route::get("/test", [TestController::class, "test"]);

Route::get("/", [DashboardController::class, "index"]);
Route::get("/dashboard", [DashboardController::class, "index"]);
Route::get("/dashboard/statistics", [DashboardController::class, "statistics"]);
Route::get("/dashboard/userManagement", [
    DashboardController::class,
    "userManagement",
]);
Route::get("/dashboard/setting", [DashboardController::class, "setting"]);

Auth::routes();

// Route::get("/home", [
//     App\Http\Controllers\HomeController::class,
//     "index",
// ])->name("home");
