<?php

namespace App\Http\Controllers;

use App\Models\CustomFieldGeneralData;
use Illuminate\Http\Request;

class CustomFieldGeneralDataController extends Controller
{
    // Show all custom field data
    public function index()
    {
        $customFieldGeneralData = CustomFieldGeneralData::all();
        return response()->json($customFieldGeneralData);
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

        $customFieldGeneralData = CustomFieldGeneralData::create($validated);
        return response()->json($customFieldGeneralData, 201);
    }

    // Show a specific custom field data
    public function show($id)
    {
        $customFieldGeneralData = CustomFieldGeneralData::findOrFail($id);
        return response()->json($customFieldGeneralData);
    }

    // Update existing custom field data
    public function update(Request $request, $id)
    {
        $customFieldGeneralData = CustomFieldGeneralData::findOrFail($id);

        $validated = $request->validate([
            'value' => 'required|string',
            'field_type' => 'required|in:text,select,checkbox,radio',
            'option_values' => 'nullable|string',
        ]);

        $customFieldGeneralData->update($validated);
        return response()->json($customFieldGeneralData);
    }

    // Delete custom field data
    public function destroy($id)
    {
        $customFieldGeneralData = CustomFieldGeneralData::findOrFail($id);
        $customFieldGeneralData->delete();
        return response()->json(null, 204);
    }
}
