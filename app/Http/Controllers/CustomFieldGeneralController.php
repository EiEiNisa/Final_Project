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
            $customField = CustomFieldGeneral::findOrFail($id);
            $customField->delete();

            session()->flash('success', 'ลบรายการสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'ไม่สามารถลบฟิลด์ได้ กรุณาลองใหม่อีกครั้ง'], 500);
        }
    }

    public function deleteOption($fieldId, $optionIndex)
{
    // ค้นหาฟิลด์ที่ต้องการแก้ไข
    $field = CustomField::findOrFail($fieldId);

    // แปลงตัวเลือกจาก JSON เป็น array
    $options = json_decode($field->options, true);

    // ตรวจสอบค่าของ $optionIndex และ $options
    \Log::info('Field ID: ' . $fieldId);
    \Log::info('Option Index: ' . $optionIndex);
    \Log::info('Options: ', $options);

    // ตรวจสอบว่า $optionIndex อยู่ใน array หรือไม่
    if (isset($options[$optionIndex])) {
        // ลบตัวเลือกจาก array
        unset($options[$optionIndex]);

        // แปลง array กลับเป็น JSON และอัปเดตฟิลด์
        $field->options = json_encode(array_values($options)); // array_values จะจัดเรียงค่าตัวเลือกใหม่หากมีการลบ

        // บันทึกการเปลี่ยนแปลง
        $field->save();

        // ส่งข้อมูลกลับเป็น JSON
        session()->flash('success', 'อัปเดตรายการสำเร็จ');
        return response()->json(['success' => true], 200);
    }

    // หากไม่พบตัวเลือกที่ต้องการลบ
    return response()->json(['success' => false, 'message' => 'ไม่พบตัวเลือกที่ต้องการลบ']);
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

            session()->flash('success', 'อัปเดตรายการสำเร็จ');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปเดต'], 500);
        }
    }
}
