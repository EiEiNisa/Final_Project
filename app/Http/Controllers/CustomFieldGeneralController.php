<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomFieldGeneral;

class CustomFieldGeneralController extends Controller
{
    public function index()
    {
        $fields = CustomFieldGeneral::all();
        return view('admin.formrecord_general_edit', compact('fields'));
    }

    public function edit()
    {
        $customFields = CustomField::all(); 
        return view('admin.formrecord_general_edit', compact('customField')); 
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

            CustomFieldGeneral::create([
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
            $customField = CustomFieldGeneral::findOrFail($id);
            $customField->delete();

            return response()->json(['success' => true, 'message' => 'ลบฟิลด์สำเร็จ']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'ไม่สามารถลบฟิลด์ได้ กรุณาลองใหม่อีกครั้ง'], 500);
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
            $customField = CustomFieldGeneral::findOrFail($id);
            $customField->update([
                'label' => $request->label,
                'name' => $request->name,
                'field_type' => $request->field_type,
                'options' => json_encode($request->options ?? []),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปเดต'], 500);
        }
    }
}
