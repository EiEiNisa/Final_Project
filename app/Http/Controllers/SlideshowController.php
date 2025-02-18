<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    public function update(Request $request, $id) {
        if ($request->hasFile('slide')) {
            $filePath = 'uploads/slide' . $id . '.png';

            // ลบรูปเก่าก่อน (ถ้ามี)
            if (Storage::exists('public/' . $filePath)) {
                Storage::delete('public/' . $filePath);
            }

            // อัปโหลดรูปใหม่ (ไม่มีการปรับขนาด)
            $request->file('slide')->storeAs('public/uploads', 'slide' . $id . '.png');

            return back()->with('success', 'อัปโหลดสไลด์เรียบร้อย!');
        }

        return back()->with('error', 'กรุณาเลือกไฟล์รูปภาพ');
    }

    public function delete($id)
    {
        $filePath = 'public/uploads/slide' . $id . '.png';

        // ตรวจสอบและลบไฟล์
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            return back()->with('success', 'ลบสไลด์สำเร็จ');
        }

        return back()->with('error', 'ไม่พบไฟล์สไลด์ที่ต้องการลบ');
    }
}