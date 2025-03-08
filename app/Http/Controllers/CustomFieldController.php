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


    public function create()
    {
        return view('admin.formrecordedit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string',
            'value' => 'nullable|string',
        ]);

        CustomField::create($request->all());

        return redirect()->route('custom-fields.index')->with('success', 'Custom field created successfully!');
    }

    public function edit(CustomField $customField)
    {
        return view('custom_fields.edit', compact('customField'));
    }

    public function update(Request $request, CustomField $customField)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $customField->update($request->all());

        return redirect()->route('custom-fields.index')->with('success', 'Custom field updated successfully!');
    }

    public function destroy(CustomField $customField)
    {
        $customField->delete();
        return redirect()->route('custom-fields.index')->with('success', 'Custom field deleted successfully!');
    }
}

