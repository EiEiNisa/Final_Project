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
        dd($request->options);
        $validatedData = $request->validate([
            'label' => 'required|string',
            'name' => 'required|string|unique:custom_fields,name',
            'field_type' => 'required|in:text,select,checkbox,radio',
            'options' => 'nullable|array', // ตัวเลือกของ Checkbox, Select, Radio
        ]);

        foreach ($request->label as $index => $label) {
            // ทำให้ options เป็น array ที่ไม่มีการซ้อน
            $options = isset($request->options[$index]) 
                ? array_merge(...array_map(function($option) {
                    return is_array($option) ? $option : [$option];
                }, $request->options[$index])) 
                : [];
        
            CustomField::create([
                'label' => $label,
                'name' => $request->name[$index],
                'field_type' => $request->field_type[$index],
                'options' => json_encode($options), // บันทึกเป็น JSON
            ]);
        }
        
}
}