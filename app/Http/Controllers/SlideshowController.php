<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slideshow; 

class SlideshowController extends Controller
{
    public function update(Request $request, $id) {
        $request->validate([
            'slide' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // ลบรูปเก่าออกก่อน
        $oldFilePath = 'public/slides/slide' . $id . '.png';
        if (Storage::exists($oldFilePath)) {
            Storage::delete($oldFilePath);
        }
    
        // อัปโหลดรูปใหม่ (บังคับเส้นทางให้ถูกต้อง)
        $filePath = storage_path('app/private/public/slides/slide' . $id . '.png');
        $request->file('slide')->move(storage_path('app/public/slides'), 'slide' . $id . '.png');        
    
        // บันทึกข้อมูลลงฐานข้อมูล
        Slideshow::updateOrCreate(
            ['id' => $id],
            ['slide_path' => $filePath]
        );
    
        return back()->with('success', 'อัปโหลดสไลด์เรียบร้อย!');
    }
    
    
    public function delete($id)
    {
        $filePath = 'public/slides/slide' . $id . '.png';

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            return back()->with('success', 'ลบสไลด์สำเร็จ');
        }

        return back()->with('error', 'ไม่พบไฟล์สไลด์ที่ต้องการลบ');
    }
}
