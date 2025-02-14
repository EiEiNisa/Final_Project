<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('disease', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recorddata_id')->constrained('recorddata')->onDelete('cascade');
            $table->boolean('diabetes')->default(false);
            $table->boolean('cerebral_artery')->default(false);
            $table->boolean('kidney')->default(false);
            $table->boolean('blood_pressure')->default(false);
            $table->boolean('heart')->default(false);
            $table->boolean('eye')->default(false);
            $table->boolean('other')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disease');
    }
};
