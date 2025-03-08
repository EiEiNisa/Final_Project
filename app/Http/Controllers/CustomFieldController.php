<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomField;
use App\Models\Recorddata;
use App\Http\Controllers\Schema;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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
        dd($request->all());
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

        return redirect()->route('customfields.store')->with('success', 'ฟิลด์ถูกสร้างเรียบร้อย');
    }
}