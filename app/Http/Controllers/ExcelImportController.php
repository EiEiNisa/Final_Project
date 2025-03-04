<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recorddata;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        $data = $request->input('data');

        if (!$data || count($data) == 0) {
            return response()->json(['message' => 'ไม่มีข้อมูลที่สามารถบันทึกได้'], 400);
        }

        try {
            foreach ($data as $row) {
                $recorddata = Recorddata::firstOrCreate([
                    'id_card' => $row['id_card'],
                    'prefix' => $row['prefix'],
                    'name' => $row['name'],
                    'surname' => $row['surname'],
                    'housenumber' => $row['housenumber'],
                    'birthdate' => $row['birthdate'],
                    'age' => $row['age'],
                    'blood_group' => $row['blood_group'],
                    'weight' => $row['weight'],
                    'height' => $row['height'],
                    'waistline' => $row['waistline'],
                    'bmi' => $row['bmi'],
                    'phone' => $row['phone'],
                    'idline' => $row['idline'],
                    'user_id' => $row['user_id'],
                ]);
            }

            return response()->json(['message' => 'นำเข้าข้อมูลสำเร็จ!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()], 500);
        }
    }
}
