<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recorddata;
use App\Models\Disease;

class UserRecordController extends Controller
{
    public function index()
{
    $recorddata = Recorddata::all(); // หรือคำสั่งที่เหมาะสมในการดึงข้อมูลจากฐานข้อมูล
    return view('user.record', compact('recorddata')); // ส่งตัวแปรไปที่ View
}

    public function showRecords(Request $request)
    {
        $query = Recorddata::query(); // ใช้ Model Recorddata
        
        // กรองข้อมูลตามเงื่อนไขที่ป้อนมา
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('house_number')) {
            $query->where('house_number', 'like', '%' . $request->input('house_number') . '%');
        }
        if ($request->filled('disease')) {
            $query->where('disease', 'like', '%' . $request->input('disease') . '%');
        }
    
        $records = $query->paginate(10);
    
        return view('user.record', compact('records'));
        
    }
// ตัวอย่างการใช้งานใน UserRecordController
public function showUserData(Request $request)
{
    // ดึงข้อมูลจากฐานข้อมูล พร้อมโหลดข้อมูลโรคที่สัมพันธ์กับ Recorddata
    $query = Recorddata::with('disease'); // ใช้ eager loading เพื่อดึงข้อมูลโรค

    // กรองข้อมูลตามคำค้นหาหรือเงื่อนไขที่กำหนด
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->input('name') . '%');
    }

    if ($request->filled('housenumber')) {
        $query->where('housenumber', 'like', '%' . $request->input('housenumber') . '%');
    }
    if ($request->has('diseases') && $request->diseases != '') {
        $disease = $request->diseases;
        $query->whereHas('diseases', function($query) use ($disease) {
            $query->where($disease, 1); // เช็คว่าโรคนั้นๆ ถูกเลือก
        });
    }
    $disease = $request->input('diseases');

    // ดึงข้อมูลจากฐานข้อมูล (เช่น paginate หรือ get)
    $recorddata = $query->paginate(10); // หรือใช้ get() แทนถ้าไม่ใช้ pagination

    // ส่งข้อมูลไปยัง View
    return view('User.record', compact('recorddata'));
}

}