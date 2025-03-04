<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recorddata;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport; // เพิ่มบรรทัดนี้
use Illuminate\Support\Facades\Log; // เพิ่มบรรทัดนี้

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file'); 

        try {
            Log::info('File info:', ['file' => $file]); // เพิ่มบรรทัดนี้
            Excel::import(new DataImport, $file); // เรียกใช้ DataImport

            return response()->json(['message' => 'นำเข้าข้อมูลสำเร็จ!'], 200);
        } catch (\Exception $e) {
            Log::error('Import error:', ['error' => $e->getMessage()]); // เพิ่มบรรทัดนี้
            return response()->json(['message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()], 500);
        }
    }
}