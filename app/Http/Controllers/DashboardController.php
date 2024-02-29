<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

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

    public function memberManagement()
    {
        $members = DB::table("members")->get();

        return view("dashboard.memberManagement", [
            "menu" => "memberManagement",
            "members" => $members,
        ]);
    }

    public function playManagement()
    {
        $members = DB::table("plays")->get();

        return view("dashboard.playManagement", [
            "menu" => "playManagement",
            "members" => $members,
        ]);
    }

    public function setting()
    {
        return view("dashboard.setting", ["menu" => "setting"]);
    }
}
