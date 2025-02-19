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
    
        $filePath = 'slides/slide' . $id . '.png';
    
        // ลบรูปเก่าออกก่อน
        if (Storage::exists('public/' . $filePath)) {
            Storage::delete('public/' . $filePath);
        }
    
        // อัปโหลดรูปใหม่
        $request->file('slide')->storeAs('public/slides', 'slide' . $id . '.png');
    
        // บันทึกหรืออัปเดตข้อมูลในฐานข้อมูล
        Slideshow::updateOrCreate(
            ['id' => $id], // ค้นหาสไลด์เดิม
            ['slide' . $id => $filePath] // อัปเดตที่อยู่ไฟล์
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
