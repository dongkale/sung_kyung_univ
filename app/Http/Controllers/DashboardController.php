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
        return view("dashboard.index", ["menu" => "statistics"]);
    }

    public function userManagement()
    {
        return view("dashboard.index", ["menu" => "userManagement"]);
    }

    public function setting()
    {
        return view("dashboard.index", ["menu" => "setting"]);
    }
}
