<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Recorddata;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->getRealPath();
            $extension = $file->getClientOriginalExtension();

            $newFileName = time() . '.' . $extension;
            $file->move(public_path('uploads'), $newFileName);

            $newFilePath = public_path('uploads') . '/' . $newFileName;

            \Log::info('Starting Excel import...');
            try {
                Excel::import(new DataImport($newFileName, $newFilePath), $newFilePath);
                \Log::info('Import successful');
                return redirect()->route('recorddata.index')->with('success', 'นำเข้าข้อมูลสำเร็จ!');
            } catch (\Exception $e) {
                \Log::error('Error during import: ' . $e->getMessage());
                return redirect()->route('recorddata.index')->with('error', 'เกิดข้อผิดพลาดระหว่างการนำเข้า: ' . $e->getMessage());
            }
        } else {
            // ถ้าไม่เจอไฟล์
            return redirect()->route('recorddata.index')->with('error', 'กรุณาอัปโหลดไฟล์!');
        }

        // ถ้าหากไม่เจอเงื่อนไขใดๆ ก็ redirect ไปยังหน้าเดิม
        return redirect()->route('recorddata.index')->with('error', 'กรุณาอัปโหลดไฟล์!');
    }
}



