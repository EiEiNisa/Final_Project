<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_zone1', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorddata_id')->constrained('recorddata')->onDelete('cascade');
            $table->boolean('zone1_normal')->default(false);
            $table->boolean('zone1_risk_group')->default(false);
            $table->boolean('zone1_good_control')->default(false);
            $table->boolean('zone1_watch_out')->default(false);
            $table->boolean('zone1_danger')->default(false);
            $table->boolean('zone1_critical')->default(false);
            $table->boolean('zone1_complications')->default(false);
            $table->boolean('zone1_heart')->default(false);
            $table->boolean('zone1_cerebrovascular')->default(false);
            $table->boolean('zone1_kidney')->default(false);
            $table->boolean('zone1_eye')->default(false);
            $table->boolean('zone1_foot')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_zone');
    }
};
