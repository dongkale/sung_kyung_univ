<?php

namespace App\Utils;

class CommonUtils
{
    public static function makeUrl(
        string $hostName,
        array $paths,
        array $params = null
    ) {
        $queryString = "";
        if ($params) {
            foreach ($params as $key => $value) {
                $queryString .= "&$key=$value";
            }
        }
        return $hostName .
            "/" .
            implode("/", $paths) .
            "?" .
            substr($queryString, 1);
    }

    public static function makeLomadUrl(array $paths, array $params = null)
    {
        return self::makeUrl(config("global.LomadUrl"), $paths, $params);
    }

    public static function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public static function isValidEmail($email)
    {
        // PHP 내장함수인 filter_var를 사용하여 주어진 문자열이 유효한 이메일 주소인지 확인합니다.
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function isValidPhoneNumber($phone)
    {
        // 숫자만 포함되어 있는지 확인
        if (!preg_match('/^[0-9]+$/', $phone)) {
            return false;
        }

        // 휴대폰 번호 형식 체크
        if (!preg_match('/^01[0-9]-?[0-9]{3,4}-?[0-9]{4}$/', $phone)) {
            return false;
        }

        return true;
    }

    public static function isValidDateOfBirth($dob)
    {
        // 숫자만 포함되어 있는지 확인
        if (!preg_match('/^[0-9]+$/', $dob)) {
            return false;
        }

        // YYYYMMDD 형식 체크
        if (!preg_match('/^(\d{4})(\d{2})(\d{2})$/', $dob, $matches)) {
            return false;
        }

        // 날짜 유효성 체크
        $year = intval($matches[1]);
        $month = intval($matches[2]);
        $day = intval($matches[3]);
        if (!checkdate($month, $day, $year)) {
            return false;
        }

        return true;
    }
}
