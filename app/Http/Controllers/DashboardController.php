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
        return view("dashboard.index");
    }

    public function statistics()
    {
        $members = DB::table("members")->get();

        return view("dashboard.statistics", [
            "members" => $members,
        ]);
    }

    public function memberManagement()
    {
        $members = DB::table("members")->get();

        return view("dashboard.memberManagement", [
            "members" => $members,
        ]);
    }

    public function playManagement()
    {
        $members = DB::table("plays")->get();

        return view("dashboard.playManagement", [
            "members" => $members,
        ]);
    }

    public function setting()
    {
        return view("dashboard.setting");
    }
}
