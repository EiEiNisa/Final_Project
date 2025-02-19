<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{
    public function update(Request $request, $id) {
        if ($request->hasFile('slide')) {
            // ดึงนามสกุลไฟล์
            $extension = $request->file('slide')->getClientOriginalExtension();
    
            // สร้างชื่อไฟล์ใหม่
            $fileName = 'slide' . $id . '_' . time() . '.' . $extension;
    
            // บันทึกไฟล์ไปยัง storage
            $path = $request->file('slide')->storeAs('public/images', $fileName);
    
            // บันทึกชื่อไฟล์ลง session
            session()->put("slide_$id", $fileName);
    
            return back()->with('success', "อัปโหลดสไลด์เรียบร้อย! ไฟล์ใหม่: $fileName");
        }
        return back()->with('error', 'กรุณาเลือกไฟล์รูปภาพ');
    }
    
    public function delete($id) {
        // กำหนดชื่อไฟล์ที่ต้องการลบ
        $fileName = 'slide' . $id . '_'; // คุณสามารถกำหนดชื่อไฟล์ตามที่คุณต้องการ
        $destinationPath = public_path('images');

        // ลบไฟล์ที่ตรงกับชื่อที่กำหนด
        $files = File::files($destinationPath);
        foreach ($files as $file) {
            if (strpos($file->getFilename(), $fileName) === 0) {
                File::delete($file);
                return back()->with('success', 'ลบสไลด์สำเร็จ: ' . $file->getFilename());
            }
        }
    
        return back()->with('error', 'ไม่พบไฟล์ที่ต้องการลบ');
    }
   
}
