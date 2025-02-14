<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorddata_id')->constrained('recorddata')->onDelete('cascade');
            $table->integer('sys');
            $table->integer('dia');
            $table->integer('pul');
            $table->decimal('body_temp', 4, 1);
            $table->integer('blood_oxygen');
            $table->integer('blood_level');
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('health_records');
    }
};
