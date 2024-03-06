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

Route::middleware(["logger"])->group(function () {
    Route::get("/memberList", [MemberController::class, "memberList"]);
    Route::get("/memberListWithStat", [
        MemberController::class,
        "memberListWithStat",
    ]);

    Route::post("/addMember", [MemberController::class, "addMember"]);
    Route::post("/editMember", [MemberController::class, "editMember"]);
    Route::post("/deleteMember", [MemberController::class, "deleteMember"]);

    Route::get("/test", [PlayController::class, "testGet"]);
    Route::post("/testPost", [PlayController::class, "testPost"]);

    Route::get("/playList", [PlayController::class, "playList"]);
    Route::get("/playDetail", [PlayController::class, "playDetail"]);

    Route::post("/editPlayDetail", [PlayController::class, "editPlayDetail"]);
    Route::post("/deletePlayDetail", [
        PlayController::class,
        "deletePlayDetail",
    ]);

    Route::post("/playLogin", [PlayController::class, "playLogin"]);
    Route::post("/playStart", [PlayController::class, "playStart"]);
    Route::post("/playStat", [PlayController::class, "playStat"]);
    Route::post("/playEnd", [PlayController::class, "playEnd"]);
    Route::post("/playLogout", [PlayController::class, "playLogout"]);

    Route::get("/selectPlayCountByMember", [
        PlayController::class,
        "selectPlayCountByMember",
    ]);

    Route::get("/selectPlayGroundCount", [
        PlayController::class,
        "selectPlayGroundCount",
    ]);

    Route::get("/selectMemberAgeCount", [
        PlayController::class,
        "selectMemberAgeCount",
    ]);

    // Route::get("/selectGrounFalseCount", [
    //     PlayController::class,
    //     "selectGrounFalseCount",
    // ]);

    Route::get("/selectGrounSuccessFalseCount", [
        PlayController::class,
        "selectGrounSuccessFalseCount",
    ]);

    Route::post("/memberListWithStatExport", [
        MemberController::class,
        "memberListWithStatExcelForListExport",
    ]);
});
