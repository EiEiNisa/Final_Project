<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('slideshows', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->default(0); // ลำดับของสไลด์
            $table->string('path'); // ที่อยู่ไฟล์รูป
            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('slideshows');
    }
};
