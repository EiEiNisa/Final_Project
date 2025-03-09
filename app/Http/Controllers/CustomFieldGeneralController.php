<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomFieldGeneral;

class CustomFieldGeneralController extends Controller
{
    public function index()
    {
        $customFields = CustomFieldGeneral::all();
        return view('admin.formrecord_general_edit', compact('customFields'));
    }

    public function edit()
    {
        $customFields = CustomFieldGeneral::all(); 
        return view('admin.formrecord_general_edit', compact('customFields')); 
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
            // ใช้ CustomFieldGeneral แทน CustomField
            $field = CustomFieldGeneral::findOrFail($id);

            // ลบข้อมูล
            $field->delete();

            session()->flash('success', 'ลบรายการสำเร็จ');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteOption($fieldId, $optionIndex)
{
    try {
        $field = CustomFieldGeneral::findOrFail($fieldId);
        $options = json_decode($field->options, true);

        if (is_array($options) && isset($options[$optionIndex])) {
            unset($options[$optionIndex]);
            $options = array_values($options);
            $field->options = json_encode($options);
            $field->save();
            session()->flash('success', 'ลบรายการสำเร็จ');
            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false, 'message' => 'ไม่พบตัวเลือกที่ต้องการลบ'], 404);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบ: ' . $e->getMessage()], 500);
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
                'options' => json_encode($request->options ?? []),  // ตรวจสอบให้แน่ใจว่า options มีค่า
            ]);

            session()->flash('success', 'อัปเดตรายการสำเร็จ');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปเดต'], 500);
        }
    }

}