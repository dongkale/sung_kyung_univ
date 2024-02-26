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

/**
 * @OA\Info(
 *     title="BIBLE UNIVERSITY", version="0.1", description="Play API Documentation"
 * ),
 * @OA\PathItem(path="/api")
 */
class PlayController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/test",
     *     tags={"API 테스트"},
     *     summary="API 테스트",
     *     description="API 테스트",
     *     @OA\Parameter(
     *         description="요청값",
     *         in="query",
     *         name="param",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="1", summary="paramter"),
     *     ),
     *     @OA\Parameter(
     *         description="요청값들",
     *         in="query",
     *         name="params",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="[1,2,3]", summary="paramters"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="success"),
     *             @OA\Property(property="param", type="string", example="1"),
     *             @OA\Property(property="params", type="string", example="[1,2,3]")
     *         )
     *     )
     * )
     */
    public function test(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "param" => "required",
            "params" => "required",
        ]);

        if ($validator->fails()) {
            return view("errors.error", ["errors" => $validator->errors()]);
        }

        $param = $request->param;
        $params = $request->params;

        return response()->json([
            "result" => "success",
            "result_data" => ["param" => $param, "params" => $params],
        ]);
    }

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
