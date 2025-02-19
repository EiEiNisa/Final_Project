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
            
            // ตั้งชื่อไฟล์ให้ตรงกับ $id
            $fileName = 'slide' . $id . '.' . $extension;
            $destinationPath = public_path('images'); // บันทึกที่ public/images/
            
            // ลบไฟล์เก่าออกก่อน (ถ้ามี)
            $oldFile = glob($destinationPath . '/slide' . $id . '.*'); // หาไฟล์ที่มีชื่อเริ่มต้นด้วย slide{id}.
            if (!empty($oldFile)) {
                File::delete($oldFile);
            }
            
            // ย้ายไฟล์ไปที่ public/images/
            $request->file('slide')->move($destinationPath, $fileName);
            
            return back()->with('success', 'อัปโหลดสไลด์เรียบร้อย! ไฟล์ใหม่: ' . $fileName);
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
   
    public function home()
{
    $slides = [];
    for ($i = 1; $i <= 6; $i++) {
        // ดึงชื่อไฟล์จาก session
        $fileName = session("slide_$i", "slide$i.png");

        // ตรวจสอบว่ามีไฟล์อยู่จริงไหม
        if (Storage::exists("public/images/$fileName")) {
            $slides[$i] = asset("storage/images/$fileName");
        } else {
            $slides[$i] = asset("images/default.png"); // ใช้รูปเริ่มต้นถ้าไม่มีไฟล์
        }
    }

    return view('home', compact('slides'));
}


}
