<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Utils\CommonUtils;

use stdClass;
use DateTime;
use DateInterval;
use Exception;

class PlayController extends Controller
{
    public function login(Request $request)
    {
        // 1. request: ids, name 으로 로그인
        // 2. process: members 테이블에서 확인
        // 3. response: ids, name, email, birth_date

        return response()->json([]);
    }

    public function playStart(Request $request)
    {
        // 1. request: ids
        // 2. process: members.login_flag, members.last_login_at 업데이트
        // 3. process: members.play_seq_no 번호 증감
        // 4. process: plays 테이블 insert
        // 5. response: play_seq_no

        return response()->json([]);
    }

    public function playStatistics(Request $request)
    {
        // 1. request: ids, play_seq_no, statistics:[{ground, step, actual_play_time, false_count, start_date, end_date}, ...]
        // 2. process: play_details 테이블 insert
        // 3. response:

        return response()->json([]);
    }

    public function playEnd(Request $request)
    {
        // 1. request: ids, start_date, end_date, total_time
        // 2. process: plays 테이블 update

        return response()->json([]);
    }

    public function logout(Request $request)
    {
        // 1. request: ids

        return response()->json([]);
    }

    public function playList(Request $request)
    {
        $selectData = DB::table("plays as p")
            ->select(
                "m.id",
                "m.ids",
                "m.name",
                "m.sex",
                "m.birth_date",
                "p.seq_no",
                "p.start_date",
                "p.end_date",
                "p.total_time",
                "p.created_at"
            )
            ->join("members as m", "m.id", "=", "p.member_id")
            ->orderBy("id", "asc")
            ->orderBy("seq_no", "asc")
            ->get()
            ->toArray();

        return response()->json($selectData);
    }

    public function playDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "play_seq_no" => "required",
        ]);

        if ($validator->fails()) {
            return view("errors.error", ["errors" => $validator->errors()]);
        }

        $memberId = $request->id;
        $playSeqNo = $request->play_seq_no;

        $selectData = DB::table("play_details as pd")
            ->select(
                "pd.seq_no",
                "pd.ground",
                "pd.step",
                "pd.actual_play_time",
                "pd.start_date",
                "pd.end_date",
                "pd.false_count",
                "pd.created_at"
            )
            ->where("pd.member_id", "=", $memberId)
            ->where("pd.seq_no", "=", $playSeqNo)
            ->orderBy("ground", "asc")
            ->orderBy("step", "asc")
            ->get()
            ->toArray();

        return response()->json($selectData);
    }

    public function editPlayDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "play_seq_no" => "required",
        ]);

        if ($validator->fails()) {
            return view("errors.error", ["errors" => $validator->errors()]);
        }

        $ground = $request->ground;
        $step = $request->step;
        $falseCount = $request->falseCount;
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        return response()->json([]);
    }
}
