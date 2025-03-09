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

        // ส่งผลลัพธ์กลับไปยังหน้า
        return response()->json(['success' => true], 200);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    public function deleteOption($fieldId, $optionIndex)
{
    // ค้นหาฟิลด์ที่ต้องการแก้ไข
    $field = CustomFieldGeneral::findOrFail($fieldId);

    // แปลงตัวเลือกจาก JSON เป็น array
    $options = json_decode($field->options, true);

    // ตรวจสอบว่า $optionIndex อยู่ใน array หรือไม่
    if (isset($options[$optionIndex])) {
        // ลบตัวเลือกจาก array
        unset($options[$optionIndex]);

        // รีดัช (Reindex) array เพื่อให้ไม่มีค่า key ที่หายไป
        $options = array_values($options);

        // แปลง array กลับเป็น JSON และอัปเดตฟิลด์
        $field->options = json_encode($options);

        // บันทึกการเปลี่ยนแปลง
        $field->save();

        session()->flash('success', 'ลบรายการสำเร็จ');
        return response()->json(['success' => true], 200);
    }

    // หากไม่พบตัวเลือกที่ต้องการลบ
    return response()->json(['success' => false, 'message' => 'ไม่พบตัวเลือกที่ต้องการลบ'], 404);
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