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
            $customField = CustomField::findOrFail($id);
            $customField->delete();

            session()->flash('success', 'ลบรายการสำเร็จ');
            return response()->json(['success' => true]);
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
        $customField = CustomField::findOrFail($id);
        $customField->label = $request->label;
        $customField->name = $request->name;
        $customField->field_type = $request->field_type;
        $customField->options = json_encode($request->options ?? []);
        $customField->save();

        session()->flash('success', 'ลบรายการสำเร็จ');
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปเดต'], 500);
    }
}

}