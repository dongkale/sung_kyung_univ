<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function memberList(Request $request)
    {
        $select_data = DB::table("members")
            ->select("*")
            ->get()
            ->toArray();

        return response()->json($select_data);
    }
}
