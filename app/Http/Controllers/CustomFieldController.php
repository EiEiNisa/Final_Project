<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomField;
use App\Models\Recorddata;
use App\Http\Controllers\Schema;

class CustomFieldController extends Controller
{
    public function index()
    {
        $fields = CustomField::all(); 
        return view('admin.formrecordedit', compact('fields'));
    }

    public function edit()
    {
        $fields = CustomField::all(); 
        return view('admin.formrecordedit', compact('fields'));
    }

    public function store(Request $request)
{
    // ตรวจสอบข้อมูลทั้งหมดที่ได้รับจากฟอร์ม
    dd($request->all()); // ตรวจสอบข้อมูลที่ส่งมา

    // ตรวจสอบว่า request มีข้อมูลที่ต้องการครบถ้วน
    $validatedData = $request->validate([
        'label' => 'required|array',  // label[] ต้องเป็น array
        'label.*' => 'required|string',  // แต่ละ label ต้องเป็น string
        'name' => 'required|array',  // name[] ต้องเป็น array
        'name.*' => 'required|string|unique:custom_fields,name',  // name[] ต้องเป็น string และ unique
        'field_type' => 'required|array',  // field_type[] ต้องเป็น array
        'field_type.*' => 'required|in:text,select,checkbox,radio',  // field_type[] ต้องเป็นหนึ่งในค่าที่กำหนด
        'options' => 'nullable|array',  // options[] ต้องเป็น array ถ้ามี
        'options.*' => 'nullable|array',  // แต่ละตัวเลือกใน options[] ต้องเป็น array
        'options.*.*' => 'nullable|string',  // แต่ละตัวเลือกต้องเป็น string
    ]);

    // วนลูปเพื่อบันทึก Custom Fields ทีละตัว
    foreach ($request->label as $index => $label) {
        // ตรวจสอบการมี options ถ้า field_type เป็น select, checkbox หรือ radio
        // ทำการ flat และรวม options ให้เป็น array เดียว
        $options = isset($request->options[$index]) 
            ? json_encode(array_merge(...array_map('array_values', $request->options[$index])), JSON_UNESCAPED_UNICODE) 
            : null;

        // บันทึก Custom Field ใหม่
        CustomField::create([
            'label' => $label,
            'name' => $request->name[$index],
            'field_type' => $request->field_type[$index],
            'options' => $options,  // ใช้ options ที่ได้แปลงเป็น JSON
        ]);
    }

    return redirect()->route('customfields.store')->with('success', 'ฟิลด์ถูกสร้างเรียบร้อย');
}

}