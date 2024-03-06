<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Config;

class MembersExcelForList implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize
{
    use HasFactory;

    protected $headings;

    public function __construct(array $headings)
    {
        $this->headings = $headings;
    }

    public function Collection()
    {
        // $selectData = Member::getListWithStat();
        $dbEncKey = env("DB_ENCRYPT_KEY");

        $selectData = DB::table("members as m")
            ->select(
                "m.ids",
                "m.name",
                DB::raw(
                    "CASE WHEN m.sex = 'M' THEN '남' ELSE '여' END as sex_kor"
                ),
                DB::raw(
                    "CONCAT(SUBSTRING(m.birth_date, 1, 4), '-', SUBSTRING(m.birth_date, 5, 2), '-', SUBSTRING(m.birth_date, 7, 2)) as birth_date"
                ),
                // DB::raw(
                //     "ROUND((TO_DAYS(NOW()) - (TO_DAYS(m.birth_date))) / 365) as age"
                // ),
                DB::raw("YEAR(CURDATE()) - YEAR(m.birth_date) AS age"),
                DB::raw(
                    "CONCAT(SUBSTRING(AES_DECRYPT(UNHEX(m.mobile_phone), '{$dbEncKey}'), 1, 3), '-',  SUBSTRING(AES_DECRYPT(UNHEX(m.mobile_phone), '{$dbEncKey}'), 4, 3), '-', SUBSTRING(AES_DECRYPT(UNHEX(m.mobile_phone), '{$dbEncKey}'), 7, 4)) as phone_number"
                ),
                DB::raw(
                    "(SELECT COUNT(*) FROM plays WHERE member_id = m.id) as play_count"
                ),
                DB::raw(
                    "(SELECT SUM(total_time) FROM plays WHERE member_id = m.id) / 60 as play_total_time"
                )
            )
            ->get()
            ->toArray();

        return collect($selectData);
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
