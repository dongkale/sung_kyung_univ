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
 *     version="1.0.0",
 *     title="Bible University Api Documentation",
 *     description="Bible University Api Documentation",
 *     @OA\Contact(
 *         name="Lee Dong Kwan",
 *         email="dklee@lennon.co.kr"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 * @OA\Server(
 *     url="/api",
 * ),
 */
class PlayController extends Controller
{
    const LOGIN_PLAY_START_GAP_TIME = 60;

    // tags : 메인 타이틀
    // description: API 설명
    /**
     * @OA\Get (
     *     path="/test",
     *     tags={"[TEST] API Get 테스트"},
     *     summary="API Get 테스트",
     *     description="API Get 테스트",
     *     @OA\Parameter(
     *         description="요청 값",
     *         in="query",
     *         name="param",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="1", summary="paramter"),
     *     ),
     *     @OA\Parameter(
     *         description="요청 값들",
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
    public function testGet(Request $request)
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
            "result_message" => "Success",
            "result_data" => ["param" => $param, "params" => $params],
        ]);
    }

    /**
     * @OA\Post (
     *     path="/testPost",
     *     tags={"[TEST] API Post 테스트"},
     *     summary="API Post 테스트",
     *     description="API Post 테스트",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *              @OA\Property(property="param", type="string", example="1", description="요청 값"),
     *              @OA\Property(property="params", type="string", example="[1,2,3]", description="요청 값들")     *
     *         )
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
            "result_message" => "Success",
            "result_data" => ["param" => $param, "params" => $params],
        ]);
    }

    /**
     * @OA\Post (
     *     path="/playLogin",
     *     summary="로그인 API",
     *     tags={"1. 로그인"},
     *     description="로그인 시도, 해당 Ids와 이름으로 로그인 시도, 여기서 ids 는 대쉬보드상의 ID",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="ids", type="string", example="001", description="유저 ids(001, 002)"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result_code", type="int", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지(유져 미존재시 Not Found)"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="int", description="회원 아이디", example="1"),
     *                      @OA\Property(property="ids", type="string", description="회원 아이디(문자열)", example="001"),
     *                      @OA\Property(property="name", type="string", description="회원 이름", example="홍길동"),
     *                      @OA\Property(property="email", type="string", description="회원이메일", example="abc@example.com"),
     *                      @OA\Property(property="birth_date", type="string", description="회원 생년월일", example="1990-01-01"),
     *                      @OA\Property(property="sex", type="string", description="회원 성별(M:남성,F:여성)", example="M"),
     *                  ),
     *            )
     *         )
     *     )
     * )
     */
    public function playLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "ids" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
        }

        $memberIds = $request->ids;

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
                ->update([
                    "try_login_at" => DB::raw("NOW()"),
                    "updated_at" => DB::raw("NOW()"),
                ]);

            DB::commit();

            Log::info(
                "[playLogin][Ok] id: {$selectData->id}, name: {$selectData->name}"
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
                "sex" => $selectData->sex,
            ],
        ]);
    }

    /**
     * @OA\Post (
     *     path="/playStart",
     *     summary="플레이 시작 API",
     *     tags={"2. 플레이 시작"},
     *     description="플레이 시작, 해당  Id(ids 아님) 플레이 시작을 알린다, 반환값으로 플레이 번호. 플레이 번호 이후 플레이 종료나 통계정보를 넘길때 사용한다",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="int", example="1", description="유저 id"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result_code", type="int", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지(유저 미존재시 Not Found)"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="int", description="회원 아이디", example="1"),
     *                      @OA\Property(property="play_seq_no", type="int", description="플레이 번호", example="1"),
     *                  ),
     *            )
     *         )
     *     )
     * )
     */
    public function playStart(Request $request)
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

    /**
     * @OA\Post (
     *     path="/playStat",
     *     summary="플레이 통계 API",
     *     tags={"3. 플레이 통계"},
     *     description="플레이 통계, 해당  Id(ids 아님), play_seq_no(플레이 번호), play_stats(플레이 통계)를 갱신한다, 기존 있는 정보는 삭제하고 새로 업데이트를 진행한다.",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="int", example="1", description="유저 id"),
     *              @OA\Property(property="play_seq_no", type="int", example="5", description="플레이 번호"),
     *              @OA\Property(property="play_stats", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="ground", type="string", description="장소(현관,거실,...)", example="거실"),
     *                      @OA\Property(property="step", type="int", description="순서(1,2,3)", example="1"),
     *                      @OA\Property(property="actual_play_time", type="int", description="소요시간(초)", example="120"),
     *                      @OA\Property(property="false_count", type="int", description="실패 횟수", example="1"),
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="결과값",
     *          @OA\JsonContent(
     *              @OA\Property(property="result_code", type="int", example="0", description="성공:0, 실패:-1"),
     *              @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지(유저 미존재시 Not Found)"),
     *              @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="int", description="회원 아이디", example="1"),
     *                      @OA\Property(property="play_seq_no", type="int", description="플레이 번호", example="1"),
     *                  ),
     *             )
     *         )
     *     )
     * )
     */
    public function playStat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "play_seq_no" => "required",
            "play_stats" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
        }

        $memberId = $request->id;
        $playSeqNo = $request->play_seq_no;
        $playStats = CommonUtils::ToObject($request->play_stats);

        $dbPlay = DB::table("plays")
            ->where("member_id", "=", $memberId)
            ->where("seq_no", "=", $playSeqNo);

        $play = $dbPlay->first();
        if (empty($play)) {
            Log::error(
                "[playStat][Check] id: {$memberId}, play_seq_no: : {$playSeqNo} invalid"
            );

            return response()->json([
                "result_code" => -1,
                "result_message" => "Invalid play_seq_no",
            ]);
        }

        $playDetail = DB::table("play_details")
            ->where("play_id", "=", $play->id)
            ->get();

        foreach ($playDetail as $item) {
            Log::info(
                "[playStat][Stat] Old List: play_id: {$play->id}, ground: {$item->ground}, step:{$item->step}, actual_play_time: {$item->actual_play_time}, false_count: {$item->false_count}, start_date: {$item->start_date}, end_date: {$item->end_date}"
            );
        }

        DB::beginTransaction();
        try {
            DB::table("play_details")
                ->where("play_id", "=", $play->id)
                ->delete();

            foreach ($playStats as $item) {
                // Log::info(
                //     "[playStat][Stat] New List: play_id: {$play->id}, ground: {$item->ground}, step:{$item->step}, actual_play_time: {$item->actual_play_time}, false_count: {$item->false_count}, start_date: {$item->start_date}, end_date: {$item->end_date}"
                // );

                Log::info(
                    "[playStat][Stat] New List: play_id: {$play->id}, ground: {$item->ground}, step:{$item->step}, actual_play_time: {$item->actual_play_time}, false_count: {$item->false_count}"
                );

                DB::table("play_details")->insertGetId([
                    "play_id" => $play->id,
                    "ground" => $item->ground,
                    "step" => $item->step,
                    "actual_play_time" => $item->actual_play_time,
                    "false_count" => $item->false_count,
                    "start_date" => empty($item->start_date)
                        ? null
                        : $item->start_date,
                    "end_date" => empty($item->end_date)
                        ? null
                        : $item->end_date,
                    "updated_at" => DB::raw("NOW()"),
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[playStat] Exception: " . $e->getMessage());
            Log::error("[playStat] Callstack:" . $e->getTraceAsString());

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        DB::table("play_logs")->insertGetId([
            "member_id" => $memberId,
            "seq_no" => $playSeqNo,
            "stat_data" => json_encode($playStats),
        ]);

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => [
                "id" => $memberId,
                "play_seq_no" => $playSeqNo,
            ],
        ]);
    }

    /**
     * @OA\Post (
     *     path="/playEnd",
     *     summary="플레이 종료 API",
     *     tags={"4. 플레이 종료"},
     *     description="플레이 종료를 알린다, Id(ids 아님) 와 플레이 번호(PlayStart 때 반환값(play_seq_no))로 요청을 한다, 반환값은 플레이 시간(초), 서버단에서 플레이 시간 계산한다",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="int", example="1", description="유저 id"),
     *              @OA\Property(property="play_seq_no", type="int", example="5", description="플레이 번호"),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result_code", type="int", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="Success", description="성공:EMPTY, 실패:에러메세지"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="int", description="회원 아이디", example="1"),
     *                      @OA\Property(property="play_seq_no", type="int", description="플레이 번호", example="5"),
     *                      @OA\Property(property="play_total_time", type="int", description="플레이 시간(초)", example="160"),
     *                  ),
     *            )
     *         )
     *     )
     * )
     */
    public function playEnd(Request $request)
    {
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
     *     path="/playLogout",
     *     summary="로그아웃 API",
     *     tags={"5. 로그아웃 "},
     *     description="로그아웃을 한다, 내부적으로 로그인 플레그를 셋팅한다",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="int", example="1", description="유저 id")
     *          ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="결과값",
     *         @OA\JsonContent(
     *             @OA\Property(property="result_code", type="int", example="0", description="성공:0, 실패:-1"),
     *             @OA\Property(property="result_message", type="string", example="", description="성공:EMPTY, 실패:에러메세지"),
     *             @OA\Property(property="result_data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="int", description="회원 아이디", example="1")
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
            "result_message" => "Success",
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

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => $selectData,
        ]);
    }

    public function playDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "play_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result_code" => -1,
                "result_message" => $validator->errors(),
            ]);
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

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => $selectData,
        ]);
    }

    public function editPlayDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "ground" => "required",
            "step" => "required",
            // "start_date" => "required",
            // "end_date" => "required",
            "false_count" => "required",
            "actual_play_time" => "required",
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

        $playDetailId = $request->id;

        $dbPlayDetail = DB::table("play_details")
            ->select("*")
            ->where("id", "=", $playDetailId);

        $playDetail = $dbPlayDetail->first();
        if (empty($playDetail)) {
            return response()->json([
                "result_code" => -1,
                "result_message" => "not found play_detail_id",
            ]);
        }

        Log::info(
            "[DeletePlayDetail] Backup: id: {$playDetailId}, ground:{$playDetail->ground}, step: {$playDetail->step}, false_count: {$playDetail->false_count}, start_date: {$playDetail->start_date}, end_date: {$playDetail->end_date}"
        );

        DB::beginTransaction();
        try {
            $dbPlayDetail->where("id", "=", $playDetailId)->delete();

            DB::commit();

            Log::info("[DeletePlayDetail] id: {$playDetailId}");
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[PlayDetail] Exception: " . $e->getMessage());
            Log::error(
                "[DeletePlayDetail] Callstack:" . $e->getTraceAsString()
            );

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        return response()->json([
            "result_code" => 0,
            "result_message" => "success",
            "result_data" => [
                "play_detail_id" => $playDetailId,
            ],
        ]);
    }

    public function selectPlayCountByMember(Request $request)
    {
        $playCount = DB::table("members as m")
            ->select(
                "p.member_id",
                "m.ids",
                "m.name",
                DB::raw("COUNT(p.id) as count")
            )
            ->join("plays as p", "m.id", "=", "p.member_id")
            ->groupBy("p.member_id")
            ->get()
            ->toArray();
        if (empty($playCount)) {
            return response()->json([
                "result_code" => -1,
                "result_message" => "Not Found",
            ]);
        }

        $data = [
            "play_count" => $playCount,
        ];

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => $data,
        ]);
    }

    public function selectPlayGroundCount(Request $request)
    {
        $memberId = $request->member_id;

        $groundCount = DB::table("play_details as pd")
            ->select("pd.ground", DB::raw("COUNT(pd.id) as count"))
            ->where("pd.step", "=", "1")
            ->when($memberId, function ($q, $memberId) {
                return $q->whereRaw(
                    "pd.play_id IN (SELECT id FROM plays WHERE member_id = {$memberId})"
                );
            })
            ->groupBy("pd.ground")
            ->get()
            ->toArray();
        if (empty($groundCount)) {
            return response()->json([
                "result_code" => -1,
                "result_message" => "Not Found",
            ]);
        }

        $data = [
            "ground_count" => $groundCount,
        ];

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => $data,
        ]);
    }

    public function selectMemberAgeCount(Request $request)
    {
        $memberAgeCount = DB::table("members as m")
            ->select(
                DB::raw("(YEAR(CURDATE()) - YEAR(m.birth_date)) as age"),
                DB::raw("COUNT(m.id) as count")
            )
            // ->groupByRaw(
            //     "(ROUND((TO_DAYS(NOW()) - (TO_DAYS(m.birth_date))) / 365))"
            // )
            ->groupByRaw("(YEAR(CURDATE()) - YEAR(m.birth_date))")
            ->get()
            ->toArray();
        if (empty($memberAgeCount)) {
            return response()->json([
                "result_code" => -1,
                "result_message" => "Not Found",
            ]);
        }

        $data = [
            "member_age_count" => $memberAgeCount,
        ];

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => $data,
        ]);
    }

    // public function selectGrounFalseCount(Request $request)
    // {
    //     $groundFalseCount = DB::table("play_details as pd")
    //         ->select(
    //             "pd.ground",
    //             DB::raw("COUNT(pd.id) as count"),
    //             DB::raw("SUM(pd.false_count) as false_count")
    //         )
    //         ->groupBy("pd.ground")
    //         ->get()
    //         ->toArray();
    //     if (empty($groundFalseCount)) {
    //         return response()->json([
    //             "result_code" => -1,
    //             "result_message" => "Not Found",
    //         ]);
    //     }

    //     $data = [
    //         "ground_count" => $groundFalseCount,
    //     ];

    //     return response()->json([
    //         "result_code" => 0,
    //         "result_message" => "Success",
    //         "result_data" => $data,
    //     ]);
    // }

    public function selectGrounSuccessFalseCount(Request $request)
    {
        $memberId = $request->member_id;

        $groundSuccessFalseCount = DB::table("play_details as pd")
            ->select(
                "pd.ground",
                DB::raw("COUNT(pd.id) as count"),
                DB::raw("SUM(IF(pd.false_count = 0, 1, 0)) as success_count"),
                DB::raw(
                    "SUM(IF(pd.false_count > 0, pd.false_count, 0)) as false_count"
                )
            )
            ->when($memberId, function ($q, $memberId) {
                return $q->whereRaw(
                    "pd.play_id IN (SELECT id FROM plays WHERE member_id = {$memberId})"
                );
            })
            ->whereNotNULL("pd.ground")
            ->groupBy("pd.ground")
            ->get()
            ->toArray();
        if (empty($groundSuccessFalseCount)) {
            return response()->json([
                "result_code" => -1,
                "result_message" => "Not Found",
            ]);
        }

        $data = [
            "stat" => $groundSuccessFalseCount,
        ];

        return response()->json([
            "result_code" => 0,
            "result_message" => "Success",
            "result_data" => $data,
        ]);
    }
}
