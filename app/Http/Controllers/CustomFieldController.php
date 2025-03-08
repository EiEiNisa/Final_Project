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
    $validatedData = $request->validate([
        'label.*' => 'required|string',
        'name.*' => 'required|string|distinct', // เพิ่ม distinct เพื่อป้องกัน name ซ้ำกันใน request เดียวกัน
        'field_type.*' => 'required|in:text,select,checkbox,radio',
        'options.*.*' => 'nullable|string', // แก้ไขการ validate options ให้รองรับ array
    ]);

    foreach ($request->label as $index => $label) {
        $options = [];
        if (isset($request->options[$index]) && is_array($request->options[$index])) {
            foreach ($request->options[$index] as $option) {
                if (!empty($option)) {
                    $options[] = $option;
                }
            }
        }

        CustomField::create([
            'label' => $label,
            'name' => $request->name[$index],
            'field_type' => $request->field_type[$index],
            'options' => json_encode($options),
        ]);
    }

    return redirect()->back()->with('success', 'Custom fields saved successfully.');
}
}