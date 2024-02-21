<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create("members", function (Blueprint $table) {
        //     $table->id();
        //     $table->string("ids")->unique();
        //     $table->string("name")->nullable();
        //     $table->string("sex")->nullable();
        //     $table->string("birth_date")->nullable(); // YYYYMMDD
        //     $table->string("mobile_phone")->nullable();
        //     $table->smallInteger("login")->nullable(); // 로그인중 여부(0:로그아웃, 1:로그인중)
        //     $table->timestamp("last_login_at")->nullable(); // 마지막 로그인 시간
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table("members", function (Blueprint $table) {
        //     Schema::dropIfExists("members");
        // });
    }
};
