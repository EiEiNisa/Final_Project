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

    public function create()
    {
        return view('admin.formrecordedit_create');
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
        return view('admin.formrecordedit_edit', compact('customField'));
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

