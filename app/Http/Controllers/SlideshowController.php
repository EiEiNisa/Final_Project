<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    public function update(Request $request)
    {
        // ตรวจสอบว่ามีไฟล์ที่อัปโหลดมาหรือไม่
        if ($request->hasFile('slides')) {
            foreach ($request->slides as $id => $slide) {
                if ($slide) {
                    $filePath = 'slides/slide' . $id . '.png';

                    // ลบรูปเก่าก่อน (ถ้ามี)
                    if (Storage::exists('public/' . $filePath)) {
                        Storage::delete('public/' . $filePath);
                    }

                    // อัปโหลดรูปใหม่ไปยัง public/slides
                    $slide->storeAs('public/slides', 'slide' . $id . '.png');
                }
            }

            return back()->with('success', 'อัปโหลดสไลด์เรียบร้อย!');
        }

        return back()->with('error', 'กรุณาเลือกไฟล์รูปภาพ');
    }

    public function delete($id)
    {
        $filePath = 'slides/slide' . $id . '.png'; // แก้ไขเส้นทางให้ตรง

        // ตรวจสอบและลบไฟล์
        if (Storage::exists('public/' . $filePath)) {
            Storage::delete('public/' . $filePath);
            return back()->with('success', 'ลบสไลด์สำเร็จ');
        }

        return back()->with('error', 'ไม่พบไฟล์สไลด์ที่ต้องการลบ');
    }
}
