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
// use Log;
use Exception;

class MemberController extends Controller
{
    const DefaultIdsNum = 3;

    public function makeIds($num)
    {
        $lengthNum = strlen((string) $num);

        $numCount =
            $lengthNum > self::DefaultIdsNum ? $lengthNum : self::DefaultIdsNum;

        return str_pad($num, $numCount, "0", STR_PAD_LEFT);
    }

    public function memberList(Request $request)
    {
        $selectData = DB::table("members")
            ->select("*")
            ->get()
            ->toArray();

        return response()->json($selectData);
    }

    public function addMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "sex" => "required",
            "birthDate" => "required",
            "mobilePhone" => "required",
        ]);

        if ($validator->fails()) {
            Log::error("[Member][Add] " . "Not Found Arguments");
            return view("errors.error", ["errors" => $validator->errors()]);
        }

        $memberName = $request->name;
        $memberEmail = $request->email;
        $memberSex = $request->sex;
        $memberBirthDate = $request->birthDate;
        $memberMobilePhone = $request->mobilePhone;

        if (!CommonUtils::isValidEmail($memberEmail)) {
            Log::error("[Member][Add] " . "Invalid Email");
            return response()->json(
                ["result_code" => -1, "result_message" => "Invalid Email"],
                400
            );
        }

        if (!CommonUtils::isValidPhoneNumber($memberMobilePhone)) {
            Log::error("[Member][Add] " . "Invalid Mobile Phone");
            return response()->json(
                [
                    "result_code" => -1,
                    "result_message" => "Invalid Mobile Phone",
                ],
                400
            );
        }

        if (!CommonUtils::isValidDateOfBirth($memberBirthDate)) {
            Log::error("[Member][Add] " . "Invalid Birth Date");
            return response()->json(
                ["result_code" => -1, "result_message" => "Invalid Birth Date"],
                400
            );
        }

        DB::beginTransaction();
        try {
            $insertId = DB::table("members")->insertGetId([
                "name" => $memberName,
                "email" => $memberEmail,
                "sex" => $memberSex,
                "birth_date" => $memberBirthDate,
                "mobile_phone" => $memberMobilePhone,
            ]);

            $ids = $this->makeIds($insertId);

            DB::table("members")
                ->where("id", "=", $insertId)
                ->update(["ids" => $ids]);

            DB::commit();

            Log::info(
                "[Member][Add] id: {$insertId}, Ids:{$ids}, Name: {$memberName}"
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[Member][Add] Exception: " . $e->getMessage());
            Log::error("[Member][Add] Callstack:" . $e->getTraceAsString());

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        return response()->json([
            "result_code" => 0,
            "result_message" => "success",
            "ids" => $ids,
        ]);
    }
    public function editMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "name" => "required",
            "email" => "required",
            "sex" => "required",
            "birthDate" => "required",
            "mobilePhone" => "required",
        ]);

        if ($validator->fails()) {
            Log::error("[Member][Edit] " . "Not Found Arguments");
            return view("errors.error", ["errors" => $validator->errors()]);
        }

        $memberId = $request->id;
        $memberIds = $request->ids;
        $memberName = $request->name;
        $memberEmail = $request->email;
        $memberSex = $request->sex;
        $memberBirthDate = $request->birthDate;
        $memberMobilePhone = $request->mobilePhone;

        if (!CommonUtils::isValidEmail($memberEmail)) {
            Log::error("[Member][Edit] " . "Invalid Email");
            return response()->json(
                ["result_code" => -1, "result_message" => "Invalid Email"],
                400
            );
        }

        if (!CommonUtils::isValidPhoneNumber($memberMobilePhone)) {
            Log::error("[Member][Edit] " . "Invalid Mobile Phone");
            return response()->json(
                [
                    "result_code" => -1,
                    "result_message" => "Invalid Mobile Phone",
                ],
                400
            );
        }

        if (!CommonUtils::isValidDateOfBirth($memberBirthDate)) {
            Log::error("[Member][Edit] " . "Invalid Birth Date");
            return response()->json(
                ["result_code" => -1, "result_message" => "Invalid Birth Date"],
                400
            );
        }

        DB::beginTransaction();
        try {
            DB::table("members")
                ->where("id", "=", $memberId)
                ->where("ids", "=", $memberIds)
                ->update([
                    "name" => $memberName,
                    "email" => $memberEmail,
                    "sex" => $memberSex,
                    "birth_date" => $memberBirthDate,
                    "mobile_phone" => $memberMobilePhone,
                ]);

            DB::commit();

            Log::info(
                "[Member][Edit] id: {$memberId}, Ids:{$memberIds}, Name: {$memberName}"
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[Member][Edit] Exception: " . $e->getMessage());
            Log::error("[Member][Edit] Callstack:" . $e->getTraceAsString());

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        return response()->json([
            "result_code" => 0,
            "result_message" => "success",
            "ids" => $memberIds,
        ]);
    }

    public function deleteMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "idList" => "required",
        ]);

        if ($validator->fails()) {
            Log::error("[Member][Delete] " . "Not Found Arguments");
            return view("errors.error", ["errors" => $validator->errors()]);
        }

        $memberIdList = $request->idList;
        // $memberIds = $request->ids;

        $selectData = DB::table("members")
            ->select("*")
            ->whereIn("id", $memberIdList)
            ->get();

        foreach ($selectData as $item) {
            Log::info(
                "[Member][Delete] id: {$item->id}, Ids:{$item->ids}, Name: {$item->name}, Sex: {$item->sex}, BirthDate: {$item->birth_date}, MobilePhone: {$item->mobile_phone}, Email: {$item->email}"
            );
        }

        $memberIdListStr = implode(",", $memberIdList);

        DB::beginTransaction();
        try {
            DB::table("members")
                ->whereIn("id", $memberIdList)
                ->delete();

            DB::commit();

            Log::info("[Member][Delete] id: {$memberIdListStr}");
        } catch (Exception $e) {
            DB::rollback();

            Log::error("[Member][Delete] Exception: " . $e->getMessage());
            Log::error("[Member][Delete] Callstack:" . $e->getTraceAsString());

            return response()->json(
                ["result_code" => -1, "result_message" => "Exception"],
                500
            );
        }

        return response()->json([
            "result_code" => 0,
            "result_message" => "success",
            "id_list" => $memberIdListStr,
        ]);
    }
}
