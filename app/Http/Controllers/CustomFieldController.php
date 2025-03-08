<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomField;

class CustomFieldController extends Controller
{
    public function index()
{
    $fields = CustomField::all(); // ดึงข้อมูลทั้งหมดจากฐานข้อมูล
    return view('admin.formrecordedit', compact('fields')); // ส่งข้อมูลไปยัง view 'admin.formrecordedit'
}

    // แสดงฟอร์มเพิ่ม/แก้ไขฟิลด์
    public function edit()
    {
        $fields = CustomField::all(); // ดึงข้อมูลฟิลด์ที่มีอยู่
        return view('admin.formrecordedit', compact('fields'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'label' => 'required|string',
        'name' => 'required|string|unique:custom_fields,name',
        'field_type' => 'required|in:text,select,checkbox,radio',
        'options' => 'nullable|array', // ตัวเลือกของ Checkbox, Select, Radio
    ]);

    // แปลงค่าของ options เป็น JSON ถ้ามีตัวเลือก
    $options = $request->has('options') ? json_encode($request->options, JSON_UNESCAPED_UNICODE) : null;

    CustomField::create([
        'label' => $validatedData['label'],
        'name' => $validatedData['name'],
        'field_type' => $validatedData['field_type'],
        'options' => $options,
    ]);

    return redirect()->route('formrecordedit')->with('success', 'ฟิลด์ถูกสร้างเรียบร้อย');
}
}

