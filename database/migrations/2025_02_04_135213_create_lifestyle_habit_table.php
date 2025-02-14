<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('lifestyle_habit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorddata_id')->constrained('recorddata')->onDelete('cascade');
            $table->boolean('drink')->default(false);
            $table->boolean('drink_sometimes')->default(false);
            $table->boolean('dont_drink')->default(false);
            $table->boolean('smoke')->default(false);
            $table->boolean('sometime_smoke')->default(false);
            $table->boolean('dont_smoke')->default(false);
            $table->boolean('troubled')->default(false);
            $table->boolean('dont_live')->default(false);
            $table->boolean('bored')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lifestyle_habit');
    }
};
