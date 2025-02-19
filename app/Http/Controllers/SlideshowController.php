<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{

    public function update(Request $request, $id) {
        if ($request->hasFile('slide')) {
            // ดึงนามสกุลไฟล์
            $extension = $request->file('slide')->getClientOriginalExtension();
    
            // สร้างชื่อไฟล์ใหม่ให้ไม่ซ้ำกัน (ใช้ timestamp)
            $fileName = 'slide' . $id . '_' . time() . '.' . $extension;
            $destinationPath = public_path('images'); // บันทึกที่ public/images/
    
            // ย้ายไฟล์ไปที่ public/images/
            $request->file('slide')->move($destinationPath, $fileName);
    
            return back()->with('success', 'อัปโหลดสไลด์เรียบร้อย! ไฟล์ใหม่: ' . $fileName);
        }
    
        return back()->with('error', 'กรุณาเลือกไฟล์รูปภาพ');
    }
    
    public function delete($fileName) {
        $destinationPath = public_path('images');
    
        if (File::exists($destinationPath . '/' . $fileName)) {
            File::delete($destinationPath . '/' . $fileName);
            return back()->with('success', 'ลบสไลด์สำเร็จ: ' . $fileName);
        }
    
        return back()->with('error', 'ไม่พบไฟล์ที่ต้องการลบ');
    }
    
}