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
     *     tags={"API Get 테스트"},
     *     summary="API Get 테스트",
     *     description="API Get 테스트",
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

    /**
     * @OA\Post (
     *     path="/api/testPost",
     *     tags={"API Post 테스트"},
     *     summary="API Post 테스트",
     *     description="API Post 테스트",
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
     *             @OA\Property(property="result", type="string", example="success")
     *         )
     *     )
     * )
     */

    public function testPost(Request $request)
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
                "p.id as p_id",
                "m.id as m_id",
                "m.ids as m_ids",
                "m.name as m_name",
                "m.sex as m_sex",
                "m.birth_date as m_birth_date",
                "p.seq_no as p_seq_no",
                "p.start_date as p_start_date",
                "p.end_date as p_end_date",
                "p.total_time as p_total_time",
                "p.created_at as p_created_at"
            )
            ->join("members as m", "m.id", "=", "p.member_id")
            ->orderBy("m_id", "asc")
            ->orderBy("p_seq_no", "asc")
            ->get()
            ->toArray();

        return response()->json($selectData);
    }

    public function playDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "play_id" => "required",
        ]);

        if ($validator->fails()) {
            return view("errors.error", ["errors" => $validator->errors()]);
        }

        $playId = $request->play_id;

        $selectData = DB::table("play_details")
            ->select(
                "id",
                "ground",
                "step",
                "actual_play_time",
                "start_date",
                "end_date",
                "false_count",
                "created_at"
            )
            ->where("play_id", "=", $playId)
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
            "ground" => "required",
            "step" => "required",
            "start_date" => "required",
            "end_date" => "required",
            "false_count" => "required",
        ]);

        if ($validator->fails()) {
            return view("errors.error", ["errors" => $validator->errors()]);
        }

        $id = $request->id;
        $ground = $request->ground;
        $step = $request->step;
        $falseCount = $request->false_count;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $actualPlayTime = $request->actual_play_time;

        $selectData = DB::table("play_details")
            ->where("id", "=", $id)
            ->first();

        DB::beginTransaction();
        try {
            DB::table("play_details")
                ->where("id", "=", $id)
                ->update([
                    "ground" => $ground,
                    "step" => $step,
                    "false_count" => $falseCount,
                    "start_date" => $startDate,
                    "end_date" => $endDate,
                    "actual_play_time" => $actualPlayTime,
                ]);
            DB::commit();

            Log::info(
                "[PlayDetail][Edit] id: {$id}, ground:{$selectData->ground}, step: {$selectData->step}, false_count: {$selectData->false_count}, start_date: {$selectData->start_date}, end_date: {$selectData->end_date}"
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[PlayDetail][Edit] Exception: " . $e->getMessage());
            Log::error(
                "[PlayDetail][Edit] Callstack:" . $e->getTraceAsString()
            );

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        return response()->json([
            "result_code" => 0,
            "result_message" => "success",
            "id" => $id,
        ]);
    }

    // DB::beginTransaction();
    // try {
    //     DB::table("play_details")
    //         ->where("id", "=", $memberId)
    //         ->where("ids", "=", $memberIds)
    //         ->update([
    //             "name" => $memberName,
    //             "email" => DB::raw(
    //                 "HEX(AES_ENCRYPT('{$memberEmail}', '{$dbEncKey}'))"
    //             ),
    //             "sex" => $memberSex,
    //             "birth_date" => $memberBirthDate,
    //             "mobile_phone" => DB::raw(
    //                 "HEX(AES_ENCRYPT('{$memberMobilePhone}', '{$dbEncKey}'))"
    //             ),
    //         ]);

    //     DB::commit();

    //     Log::info(
    //         "[Member][Edit] id: {$memberId}, Ids:{$memberIds}, Name: {$memberName}"
    //     );
    // } catch (Exception $e) {
    //     DB::rollback();

    //     Log::error("[Member][Edit] Exception: " . $e->getMessage());
    //     Log::error("[Member][Edit] Callstack:" . $e->getTraceAsString());

    //     return response()->json(
    //         ["result_code" => -1, "result_message" => "Exception"],
    //         500
    //     );
    // }

    // return response()->json([
    //     "result_code" => 0,
    //     "result_message" => "success",
    //     "ids" => $memberIds,
    // ]);
}
