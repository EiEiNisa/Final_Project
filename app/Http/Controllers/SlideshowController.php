<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{

    public function update(Request $request, $id) {
        if ($request->hasFile('slide')) {
            // สร้างชื่อไฟล์ที่ไม่ซ้ำ
            $fileName = 'slide' . $id . '.png'; 
            $destinationPath = public_path('images'); // บันทึกที่ public/images/
            
            // ลบไฟล์เก่าถ้ามี
            if (File::exists($destinationPath . '/' . $fileName)) {
                File::delete($destinationPath . '/' . $fileName);
            }
            
            // ย้ายไฟล์ไปที่ public/images/
            $request->file('slide')->move($destinationPath, $fileName);
    
            return back()->with('success', 'อัปโหลดสไลด์เรียบร้อย!');
        }
    
        return back()->with('error', 'กรุณาเลือกไฟล์รูปภาพ');
    }
    
    public function delete($id) {
        $fileName = 'slide' . $id . '.png';
        $destinationPath = public_path('images');

        // ตรวจสอบและลบไฟล์
        if (File::exists($destinationPath . '/' . $fileName)) {
            File::delete($destinationPath . '/' . $fileName);
            return back()->with('success', 'ลบสไลด์สำเร็จ');
        }

        return back()->with('error', 'ไม่พบไฟล์สไลด์ที่ต้องการลบ');
    }
}