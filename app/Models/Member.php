<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "id",
        "ids",
        "email",
        "name",
        "sex",
        "birth_date",
        "mobile_phone",
        "play_seq_no",
        "login_flag",
        "try_login_at",
        "last_login_at",
        "created_at",
        "updated_at",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["email", "mobile_phone"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public static function getListWithStat()
    {
        $dbEncKey = env("DB_ENCRYPT_KEY");

        $selectData = DB::table("members as m")
            ->select(
                "m.id",
                "m.ids",
                DB::raw("AES_DECRYPT(UNHEX(m.email), '{$dbEncKey}') as email"),
                "m.name",
                "m.sex",
                "m.birth_date",
                // DB::raw(
                //     "ROUND((TO_DAYS(NOW()) - (TO_DAYS(m.birth_date))) / 365) as age"
                // ),
                DB::raw("YEAR(CURDATE()) - YEAR(m.birth_date) AS age"),
                DB::raw(
                    "AES_DECRYPT(UNHEX(m.mobile_phone), '{$dbEncKey}') as mobile_phone"
                ),
                "m.login_flag",
                "m.last_login_at",
                DB::raw(
                    "(SELECT COUNT(*) FROM plays WHERE member_id = m.id) as play_count"
                ),
                DB::raw(
                    "(SELECT SUM(total_time) FROM plays WHERE member_id = m.id) as play_total_time"
                ),
                "m.created_at"
            )
            ->get()
            ->toArray();

        return $selectData;
    }

    public static function getList()
    {
        $dbEncKey = env("DB_ENCRYPT_KEY");

        $selectData = DB::table("members as m")
            ->select(
                "m.id",
                "m.ids",
                DB::raw("AES_DECRYPT(UNHEX(m.email), '{$dbEncKey}') as email"),
                "m.name",
                "m.sex",
                "m.birth_date",
                // DB::raw(
                //     "ROUND((TO_DAYS(NOW()) - (TO_DAYS(m.birth_date))) / 365) as age"
                // ),
                DB::raw("YEAR(CURDATE()) - YEAR(m.birth_date) AS age"),
                DB::raw(
                    "AES_DECRYPT(UNHEX(m.mobile_phone), '{$dbEncKey}') as mobile_phone"
                ),
                "m.login_flag",
                "m.last_login_at",
                DB::raw(
                    "(SELECT COUNT(*) FROM plays WHERE member_id = m.id) as play_count"
                ),
                DB::raw(
                    "(SELECT SUM(total_time) FROM plays WHERE member_id = m.id) as play_total_time"
                ),
                "m.created_at"
            )
            ->get()
            ->toArray();

        return $selectData;
    }
}
