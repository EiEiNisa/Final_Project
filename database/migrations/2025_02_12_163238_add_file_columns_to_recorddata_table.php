<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('recorddata', function (Blueprint $table) {
        $table->string('user_name')->nullable();
    });
}

public function down()
{
    Schema::table('recorddata', function (Blueprint $table) {
        $table->dropColumn(['user_name']); // ลบคอลัมน์หาก rollback
    });
}

};
