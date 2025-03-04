<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recorddata;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport; // เพิ่มบรรทัดนี้

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file'); 

        try {
            Excel::import(new DataImport, $file); // เรียกใช้ DataImport

            return response()->json(['message' => 'นำเข้าข้อมูลสำเร็จ!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()], 500);
        }
    }
}