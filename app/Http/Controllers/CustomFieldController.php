<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomField;
use App\Models\Recorddata;
use App\Http\Controllers\Schema;
use Illuminate\Support\Arr;

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
    // ตรวจสอบข้อมูลที่รับมา
    dd($request->all());

    // ตรวจสอบว่า request มีข้อมูลที่ต้องการครบถ้วน
    $validatedData = $request->validate([
        'label' => 'required|array',
        'label.*' => 'required|string',
        'name' => 'required|array',
        'name.*' => 'required|string|unique:custom_fields,name',
        'field_type' => 'required|array',
        'field_type.*' => 'required|in:text,select,checkbox,radio',
        'options' => 'nullable|array',
        'options.*' => 'nullable',
    ]);

    // วนลูปเพื่อบันทึก Custom Fields ทีละตัว
    foreach ($request->label as $index => $label) {
        // ตรวจสอบและทำให้ options เป็น array ที่ไม่มีการซ้อน
        $options = isset($request->options[$index]) 
        ? json_encode(Arr::flatten( (array) ($request->options[$index] ?? [])), JSON_UNESCAPED_UNICODE) 
        : null;

        // บันทึก Custom Field ใหม่
        CustomField::create([
            'label' => $label,
            'name' => $request->name[$index],
            'field_type' => $request->field_type[$index],
            'options' => $options,
        ]);
    }

    return redirect()->route('customfields.store')->with('success', 'ฟิลด์ถูกสร้างเรียบร้อย');
}

}