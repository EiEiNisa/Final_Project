<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('elderly_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorddata_id')->constrained('recorddata')->onDelete('cascade');
            $table->boolean('help_yourself')->default(false);
            $table->boolean('can_help')->default(false);
            $table->boolean('cant_help')->default(false);
            $table->boolean('caregiver')->default(false);
            $table->boolean('have_caregiver')->default(false);
            $table->boolean('no_caregiver')->default(false);
            $table->boolean('group1')->default(false);
            $table->boolean('group2')->default(false);
            $table->boolean('group3')->default(false);
            $table->boolean('house')->default(false);
            $table->boolean('society')->default(false); 
            $table->boolean('bed_ridden')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elderly_information');
    }
};
