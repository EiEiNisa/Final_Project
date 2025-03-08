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

    // บันทึกฟิลด์ที่ผู้ใช้เพิ่มหรือแก้ไข
    public function store(Request $request)
    {
        // ตรวจสอบและบันทึกฟิลด์ที่เพิ่มเข้ามา
        $request->validate([
            'name' => 'required|unique:custom_fields',
            'label' => 'required',
            'field_type' => 'required',
        ]);

        CustomField::create([
            'name' => $request->input('name'),
            'label' => $request->input('label'),
            'field_type' => $request->input('field_type'),
            'options' => $request->input('options') ?? null,
        ]);

        return redirect()->route('customfields.edit')->with('success', 'บันทึกฟิลด์สำเร็จ');
    }
}

