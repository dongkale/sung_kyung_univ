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
        // 3. response: id, name, email, birth_date

        return response()->json([]);
    }

    public function playStart(Request $request)
    {
        // 1. request: id
        // 2. process: members.login_flag, members.last_login_at 업데이트
        // 3. process: members.play_seq_no 번호 증감
        // 4. response: play_seq_no

        return response()->json([]);
    }

    public function playEnd(Request $request)
    {
        // 1. request: id, play_seq_no, result:[{ground, step, actual_play_time, false_count, start_date, date_date}, ...]
        // 2. process: plays, play_log 테이블에 저장
        // 3. response:

        return response()->json([]);
    }

    public function logout(Request $request)
    {
        // 1. request: id

        return response()->json([]);
    }
}
