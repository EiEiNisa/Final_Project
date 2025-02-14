<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('health_zone2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorddata_id')->constrained('recorddata')->onDelete('cascade');
            $table->boolean('zone2_normal')->default(false);
            $table->boolean('zone2_risk_group')->default(false);
            $table->boolean('zone2_good_control')->default(false);
            $table->boolean('zone2_watch_out')->default(false);
            $table->boolean('zone2_danger')->default(false);
            $table->boolean('zone2_critical')->default(false);
            $table->boolean('zone2_complications')->default(false);
            $table->boolean('zone2_heart')->default(false);
            $table->boolean('zone2_eye')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_zone2');
    }
};
