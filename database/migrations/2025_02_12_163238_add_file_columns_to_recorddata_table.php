<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('recorddata', function (Blueprint $table) {
        $table->string('file_name')->nullable(); // เพิ่มคอลัมน์ file_name
        $table->string('file_path')->nullable(); // เพิ่มคอลัมน์ file_path
    });
}

public function down()
{
    Schema::table('recorddata', function (Blueprint $table) {
        $table->dropColumn(['file_name', 'file_path']); // ลบคอลัมน์หาก rollback
    });
}

};
