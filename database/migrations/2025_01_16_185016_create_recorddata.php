<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recorddata', function (Blueprint $table) {
            $table->id();
            $table->char('id_card', 13)->unique();
            $table->string('prefix');
            $table->string('name');
            $table->string('surname');
            $table->string('housenumber')->nullable();
            $table->date('birthdate');
            $table->integer('age');
            $table->enum('blood_group', ['A', 'B', 'AB', 'O'])->nullable();
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->decimal('waistline', 5, 2);
            $table->decimal('bmi', 5, 2);
            $table->string('phone');
            $table->string('idline');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('recorddata');
    }
    
};