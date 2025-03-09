<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomField;

class CustomFieldController extends Controller
{
    public function index()
    {
        $fields = CustomField::all(); 
        return view('admin.formrecordedit', compact('fields'));
    }

    public function edit()
    {
        $customFields = CustomField::all(); 
        return view('admin.formrecordedit', compact('customFields'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label.*' => 'required|string',
            'name.*' => 'required|string|distinct', 
            'field_type.*' => 'required|in:text,select,checkbox,radio',
            'options.*.*' => 'nullable|string', 
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

        return redirect()->back()->with('success', 'เพิ่มรายการสำเร็จ');
    }

    public function delete($id)
    {
        try {
            $field = CustomField::findOrFail($id);
            $field->delete();
            session()->flash('success', 'ลบรายการสำเร็จ');
            return response()->json(['success' => true, 'message' => 'ลบรายการสำเร็จ'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'ไม่สามารถลบข้อมูลได้'], 500);
        }
    }

    public function deleteOption($fieldId, $optionIndex)
{
    try {
        $field = CustomFieldGeneral::findOrFail($fieldId);
        $options = json_decode($field->options, true);

        if (!is_array($options)) {
            return response()->json(['success' => false, 'message' => 'ข้อมูลตัวเลือกไม่ถูกต้อง'], 500);
        }

        if (array_key_exists($optionIndex, $options)) {
            unset($options[$optionIndex]);

            // ใช้ array_values() เพื่อรีเซ็ต index ใหม่
            $options = array_values($options);
            $field->options = json_encode($options);
            $field->save();

            return response()->json(['success' => true, 'message' => 'ลบตัวเลือกสำเร็จ'], 200);
        }

        return response()->json(['success' => false, 'message' => 'ไม่พบตัวเลือกที่ต้องการลบ'], 404);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()], 500);
    }
}

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'label' => 'required|string',
            'name' => 'required|string|distinct',
            'field_type' => 'required|in:text,select,checkbox,radio',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string',
        ]);

        try {
            $customField = CustomField::findOrFail($id);
            $customField->label = $request->label;
            $customField->name = $request->name;
            $customField->field_type = $request->field_type;
            $customField->options = json_encode($request->options ?? []);
            $customField->save();

            session()->flash('success', 'อัปเดตรายการสำเร็จ');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปเดต'], 500);
        }
    }
}