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
        $customFields = CustomField::all(); 
        $fields = CustomField::all(); 
        return view('admin.formrecordedit', compact('fields','customFields'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'label.*' => 'required|string',
        'name.*' => 'required|string|distinct', 
        'field_type.*' => 'required|in:text,select,checkbox,radio',
        'options.*' => 'nullable|string',
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
            // ใช้ CustomFieldGeneral แทน CustomField
            $field = CustomField::findOrFail($id);

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
        // ค้นหาฟิลด์ที่ต้องการแก้ไข
        $field = CustomField::findOrFail($fieldId);

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