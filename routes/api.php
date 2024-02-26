<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\PlayController;

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

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::get("/memberList", [MemberController::class, "memberList"]);

Route::post("/addMember", [MemberController::class, "addMember"]);
Route::post("/editMember", [MemberController::class, "editMember"]);
Route::post("/deleteMember", [MemberController::class, "deleteMember"]);

Route::get("/test", [PlayController::class, "test"]);
Route::post("/testPost", [PlayController::class, "testPost"]);

Route::get("/playList", [PlayController::class, "playList"]);
Route::get("/playDetail", [PlayController::class, "playDetail"]);

Route::post("/editPlayDetail", [PlayController::class, "editPlayDetail"]);

Route::post("/login", [PlayController::class, "playLogin"]);
