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
        Schema::create('custom_field_general', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ชื่อของฟิลด์ เช่น 'married_status'
            $table->string('label'); // ชื่อแสดงใน UI เช่น 'คุณแต่งงานหรือยัง'
            $table->enum('field_type', ['text', 'select', 'checkbox', 'radio']); // ชนิดของฟิลด์
            $table->text('options')->nullable(); // ตัวเลือกถ้ามี เช่น สำหรับ 'select' หรือ 'radio'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields_general');
    }

    public function customFields(): HasMany
    {
        return $this->hasMany(CustomField::class, 'recorddata_id'); 
    }
};
