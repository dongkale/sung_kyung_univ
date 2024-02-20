<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view("dashboard.index", ["menu" => "dashboard"]);
    }

    public function statistics()
    {
        $members = DB::table("members")->get();

        return view("dashboard.statistics", [
            "menu" => "statistics",
            "members" => $members,
        ]);
    }

    public function userManagement()
    {
        $members = DB::table("members")->get();

        return view("dashboard.userManagement", [
            "menu" => "userManagement",
            "members" => $members,
        ]);
    }

    public function setting()
    {
        return view("dashboard.setting", ["menu" => "setting"]);
    }
}