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
        Schema::create("members", function (Blueprint $table) {
            $table->id();
            $table->string("id_string")->unique();
            $table->string("name");
            $table->string("mobile_phone")->nullable();
            $table->smallInteger("play")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("members", function (Blueprint $table) {
            Schema::dropIfExists("members");
        });
    }
};
