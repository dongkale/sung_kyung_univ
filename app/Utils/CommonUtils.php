<?php

namespace App\Utils;

use stdClass;

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

    public static function ToObject($array)
    {
        // Create new stdClass object
        $object = new stdClass();

        // Use loop to convert array into
        // stdClass object
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = CommonUtils::ToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    // stdClass -> Array 로 변경
    // public static function objectToArray($array)
    // {
    //     if (is_object($array)) {
    //         // Gets the properties of the given object
    //         // with get_object_vars function
    //         $array = get_object_vars($array);
    //     }

    //     if (is_array($array)) {
    //         /*
    //          * Return array converted to object
    //          * Using __FUNCTION__ (Magic constant)
    //          * for recursive call
    //          */
    //         return array_map(__FUNCTION__, $array);
    //     } else {
    //         // Return array
    //         return $array;
    //     }
    // }

    // Array -> stdClass 로 변경
    // public static function arrayToObject($array)
    // {
    //     if (!is_array($array)) {
    //         return $array;
    //     }

    //     $object = new stdClass();
    //     if (is_array($array) && count($array) > 0) {
    //         foreach ($array as $name => $value) {
    //             $name = strtolower(trim($name));
    //             if (!empty($name)) {
    //                 $object->$name = CommonUtils::arrayToObject($value);
    //             }
    //         }
    //         return $object;
    //     } else {
    //         return false;
    //     }
    // }
}
