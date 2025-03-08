<?php

namespace App\Http\Controllers;

use App\Models\CustomFieldData;
use Illuminate\Http\Request;

class CustomFieldDataController extends Controller
{
    // Show all custom field data
    public function index()
    {
        $customFieldData = CustomFieldData::all();
        return response()->json($customFieldData);
    }

    // Store new custom field data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recorddata_id' => 'required|exists:recorddata,id',
            'custom_field_id' => 'required|exists:custom_fields,id',
            'value' => 'required|string',
            'field_type' => 'required|in:text,select,checkbox,radio',
            'option_values' => 'nullable|string',
        ]);

        $customFieldData = CustomFieldData::create($validated);
        return response()->json($customFieldData, 201);
    }

    // Show a specific custom field data
    public function show($id)
    {
        $customFieldData = CustomFieldData::findOrFail($id);
        return response()->json($customFieldData);
    }

    // Update existing custom field data
    public function update(Request $request, $id)
    {
        $customFieldData = CustomFieldData::findOrFail($id);

        $validated = $request->validate([
            'value' => 'required|string',
            'field_type' => 'required|in:text,select,checkbox,radio',
            'option_values' => 'nullable|string',
        ]);

        $customFieldData->update($validated);
        return response()->json($customFieldData);
    }

    // Delete custom field data
    public function destroy($id)
    {
        $customFieldData = CustomFieldData::findOrFail($id);
        $customFieldData->delete();
        return response()->json(null, 204);
    }
}
