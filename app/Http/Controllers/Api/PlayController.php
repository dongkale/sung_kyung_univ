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
    const LOGIN_PLAY_START_GAP_TIME = 6000;

    // tags : 메인 타이틀
    // description: API 설명
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
     *             @OA\Property(property="result_code", type="int", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="param", type="string", description="요청 param", example="1"),
     *                      @OA\Property(property="params", type="string", description="요청 param", example="[1,2,3]"),
     *                  ),
     *            )
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
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
        }

        $param = $request->param;
        $params = $request->params;

        return response()->json([
            "result_code" => 0,
            "result_message" => "",
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
     *             @OA\Property(property="result_code", type="int", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="param", type="string", description="요청 param", example="1"),
     *                      @OA\Property(property="params", type="string", description="요청 param", example="[1,2,3]"),
     *                  ),
     *            )
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
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
        }

        $param = $request->param;
        $params = $request->params;

        return response()->json([
            "result_code" => 0,
            "result_message" => "",
            "result_data" => ["param" => $param, "params" => $params],
        ]);
    }

    /**
     * @OA\Post (
     *     path="/api/playLogin",
     *     summary="로그인 API",
     *     tags={"로그인"},
     *     description="로그인 시도, 해당 Ids와 이름으로 로그인 시도, 여기서 ids 는 대쉬보드상의 ID",
     *     @OA\Parameter(
     *         description="요청 ids 값",
     *         in="query",
     *         name="ids",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="001", summary="로그인 IDS"),
     *     ),
     *     @OA\Parameter(
     *         description="요청 이름",
     *         in="query",
     *         name="name",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="홍길동", summary="로그인 이름"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result_code", type="string", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지(유져 미존재시 Not Found)"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", description="회원 아이디", example="1"),
     *                      @OA\Property(property="ids", type="string", description="회원 아이디(문자열 포맷)", example="001"),
     *                      @OA\Property(property="name", type="string", description="회원 이름", example="홍길동"),
     *                      @OA\Property(property="email", type="string", description="회원이메일", example="abc@example.com"),
     *                      @OA\Property(property="birth_date", type="string", description="회원 생년월일", example="1990-01-01"),
     *                  ),
     *            )
     *         )
     *     )
     * )
     */
    public function playLogin(Request $request)
    {
        // 1. request: ids, name 으로 로그인
        // 2. process: members 테이블에서 확인
        // 3. response: id, name, email, birth_date

        $validator = Validator::make($request->all(), [
            "ids" => "required",
            "name" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
        }

        $params = http_build_query($request->all());
        Log::info("[PlayStart][Request] params: {$params}");

        $memberIds = $request->ids;
        $memberName = $request->name;

        $dbEncKey = env("DB_ENCRYPT_KEY");

        $selectData = DB::table("members")
            ->select(
                "id",
                "ids",
                DB::raw("AES_DECRYPT(UNHEX(email), '{$dbEncKey}') as email"),
                "name",
                "sex",
                "birth_date",
                DB::raw(
                    "AES_DECRYPT(UNHEX(mobile_phone), '{$dbEncKey}') as mobile_phone"
                ),
                "login_flag",
                "last_login_at",
                "created_at"
            )
            ->where("ids", "=", $memberIds)
            ->where("name", "=", $memberName)
            ->get()
            ->first();
        if (empty($selectData)) {
            return response()->json([
                "result_code" => -1,
                "result_message" => "User Not Found",
            ]);
        }

        DB::beginTransaction();
        try {
            // login 시도 시간 남겨서 playStart 에서 체크한다
            DB::table("members")
                ->where("ids", "=", $memberIds)
                ->where("name", "=", $memberName)
                ->update([
                    "try_login_at" => DB::raw("NOW()"),
                    "updated_at" => DB::raw("NOW()"),
                ]);

            DB::commit();

            Log::info(
                "[playLogin][Ok] id: {$selectData->id}, name: {$memberName}"
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[PlayStart] Exception: " . $e->getMessage());
            Log::error("[PlayStart] Callstack:" . $e->getTraceAsString());

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }
        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => [
                "id" => $selectData->id,
                "ids" => $selectData->ids,
                "name" => $selectData->name,
                "email" => $selectData->email,
                "birth_date" => $selectData->birth_date,
            ],
        ]);
    }

    /**
     * @OA\Post (
     *     path="/api/playStart",
     *     summary="플레이 시작 API",
     *     tags={"플레이 시작"},
     *     description="플레이 시작, 해당  Id(ids 아님) 플레이 시작을 알린다, 반환값으로 플레이 번호. 플레이 번호 이후 플레이 종료나 통계정보를 넘길때 사용한다",
     *     @OA\Parameter(
     *         description="요청 id 값",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="1", summary="로그인 ID"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result_code", type="string", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지(유저 미존재시 Not Found)"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", description="회원 아이디", example="1"),
     *                      @OA\Property(property="play_seq_no", type="string", description="플레이 번호", example="1"),
     *                  ),
     *            )
     *         )
     *     )
     * )
     */
    public function playStart(Request $request)
    {
        // 1. request: id
        // 2. process: members.try_login_at 시간이 5초 안쪽인지 체크
        // 3. process: members.login_flag, members.last_login_at 업데이트
        // 4. process: members.play_seq_no 번호 증감
        // 5. process: plays 테이블 insert
        // 6. response: play_seq_no
        $validator = Validator::make($request->all(), [
            "id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
        }

        $params = http_build_query($request->all());
        Log::info("[PlayStart][Request] params: {$params}");

        $playSeqNo = 0;

        $memberId = $request->id;

        $loginGapTime = self::LOGIN_PLAY_START_GAP_TIME;

        $dbMember = DB::table("members")
            ->where("id", "=", $memberId)
            ->whereRaw(
                "TIMESTAMPDIFF(SECOND, try_login_at , NOW()) < {$loginGapTime}"
            );

        $member = $dbMember->first();
        if (empty($member)) {
            Log::error("[PlayStart][Check] id: {$memberId} is not login");
            return response()->json([
                "result_code" => -1,
                "result_message" => "Not Login",
            ]);
        }

        // Log::info(
        //     "[PlayStart][LoginCheck] id: {$memberId}({$member->ids}), name: {$member->name}"
        // );

        DB::beginTransaction();
        try {
            $dbMember->update([
                "login_flag" => "1",
                "last_login_at" => DB::raw("NOW()"),
                "play_seq_no" => DB::raw("play_seq_no + 1"),
                "updated_at" => DB::raw("NOW()"),
            ]);

            $member = $dbMember->first();

            $playId = DB::table("plays")->insertGetId([
                "member_id" => $memberId,
                "seq_no" => $member->play_seq_no,
                "start_date" => DB::raw("NOW()"),
                "updated_at" => DB::raw("NOW()"),
            ]);

            DB::commit();

            $playSeqNo = $member->play_seq_no;

            Log::info(
                "[PlayStart][Ok] id: {$memberId}, name: {$member->name}, play_seq_no: {$member->play_seq_no}, play_id: {$playId}"
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[PlayStart] Exception: " . $e->getMessage());
            Log::error("[PlayStart] Callstack:" . $e->getTraceAsString());

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => [
                "id" => $memberId,
                "play_seq_no" => $playSeqNo,
            ],
        ]);
    }

    public function playStatistics(Request $request)
    {
        // 1. request: ids, play_seq_no, statistics:[{ground, step, actual_play_time, false_count, start_date, end_date}, ...]
        // 2. process: play_details 테이블 insert
        // 3. response:

        return response()->json([]);
    }

    /**
     * @OA\Post (
     *     path="/api/playEnd",
     *     summary="플레이 종료 API",
     *     tags={"플레이 종료"},
     *     description="플레이 종료를 알린다, Id(ids 아님) 와 플레이 번호(PlayStart 때 반환값(play_seq_no))로 요청을 한다, 반환값은 플레이 시간(초), 서버단에서 플레이 시간 계산한다",
     *     @OA\Parameter(
     *         description="요청 id 값",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="1", summary="login ID"),
     *     ),
     *     @OA\Parameter(
     *         description="요청 play_seq_no 값",
     *         in="query",
     *         name="play_seq_no",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="5", summary="play seq_no"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result_code", type="string", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", description="회원 아이디", example="1"),
     *                      @OA\Property(property="play_seq_no", type="string", description="플레이 번호", example="5"),
     *                      @OA\Property(property="play_total_time", type="string", description="플레이 시간(초)", example="160"),
     *                  ),
     *            )
     *         )
     *     )
     * )
     */
    public function playEnd(Request $request)
    {
        // 1. request: id, play_seq_no, start_date, end_date, total_time
        // 2. process: plays 테이블 update
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "play_seq_no" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
        }

        $params = http_build_query($request->all());
        Log::info("[playEnd][Request] params: {$params}");

        $totalTime = 0;

        // $currentTime = date("Y-m-d H:i:s");

        $memberId = $request->id;
        $playSeqNo = $request->play_seq_no;

        // $startDate = $request->start_date;
        // $endDate = $request->end_date;
        // $totalTime = $request->total_time;

        $dbPlay = DB::table("plays")
            ->where("member_id", "=", $memberId)
            ->where("seq_no", "=", $playSeqNo);

        $play = $dbPlay->first();
        if (empty($play)) {
            Log::error(
                "[PlayEnd][Check] id: {$memberId}, play_seq_no: : {$playSeqNo} invalid"
            );
            return response()->json([
                "result_code" => -1,
                "result_message" => "Invalid play_seq_no",
            ]);
        }

        // Log::info(
        //     "[PlayEnd][Check] id: {$memberId}, play_seq_no: {$playSeqNo}"
        // );

        DB::beginTransaction();
        try {
            $dbPlay->update([
                "total_time" => DB::raw(
                    "TIMESTAMPDIFF(SECOND, start_date, NOW())"
                ),
                "end_date" => DB::raw("NOW()"),
                "updated_at" => DB::raw("NOW()"),
            ]);

            DB::commit();

            $totalTime = $dbPlay->first()->total_time;

            Log::info(
                "[PlayEnd][Ok] id: {$memberId}, play_seq_no: {$playSeqNo}, total_time: {$totalTime}"
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[PlayEnd] Exception: " . $e->getMessage());
            Log::error("[PlayEnd] Callstack:" . $e->getTraceAsString());

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => [
                "id" => $memberId,
                "play_seq_no" => $playSeqNo,
                "play_total_time" => $totalTime,
            ],
        ]);
    }

    /**
     * @OA\Post (
     *     path="/api/playLogout",
     *     summary="로그아웃 API",
     *     tags={"로그아웃 "},
     *     description="로그아웃을 한다, 내부적으로 로그인 플레그를 셋팅한다",
     *     @OA\Parameter(
     *         description="요청 id 값",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="1", summary="logout ID"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result_code", type="string", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", description="회원 아이디", example="1")
     *                  ),
     *            )
     *         )
     *     )
     * )
     */
    public function playLogout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
        }

        $params = http_build_query($request->all());
        Log::info("[PlayLogout][Request] params: {$params}");

        $memberId = $request->id;

        $dbMember = DB::table("members")->where("id", "=", $memberId);

        $member = $dbMember->first();
        if (empty($member)) {
            Log::error("[PlayLogout][Check] id: {$memberId} invalid");
            return response()->json([
                "result_code" => -1,
                "result_message" => "not found member id",
            ]);
        }

        DB::beginTransaction();
        try {
            $dbMember->update([
                "login_flag" => "0",
                "updated_at" => DB::raw("NOW()"),
            ]);

            DB::commit();

            Log::info("[PlayLogout][Ok] id: {$memberId}");
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[PlayLogout] Exception: " . $e->getMessage());
            Log::error("[PlayLogout] Callstack:" . $e->getTraceAsString());

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        return response()->json([
            "result_code" => 0,
            "result_message" => "success",
            "result_data" => [
                "id" => $memberId,
            ],
        ]);
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
            return response()->json(
                ["result_code" => -1, "result_message" => $validator->errors()],
                500
            );
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

    public function deletePlayDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(
                ["result_code" => -1, "result_message" => $validator->errors()],
                500
            );
        }

        $id = $request->id;

        $selectData = DB::table("play_details")
            ->where("id", "=", $id)
            ->first();

        DB::beginTransaction();
        try {
            DB::table("play_details")
                ->where("id", "=", $id)
                ->delete();
            DB::commit();

            Log::info(
                "[PlayDetail][Delete] id: {$id}, ground:{$selectData->ground}, step: {$selectData->step}, false_count: {$selectData->false_count}, start_date: {$selectData->start_date}, end_date: {$selectData->end_date}"
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[PlayDetail][Delete] Exception: " . $e->getMessage());
            Log::error(
                "[PlayDetail][Delete] Callstack:" . $e->getTraceAsString()
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
