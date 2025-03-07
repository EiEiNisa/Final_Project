<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    // แสดงหน้าจัดการสไลด์
    public function index()
    {
        $slides = Slideshow::orderBy('order')->get();
        return view('admin.slideshow.index', compact('slides'));
    }

    // เพิ่มสไลด์ใหม่
    public function store(Request $request)
{
    $request->validate([
        'slide' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $file = $request->file('slide');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $destinationPath = public_path('images'); // เก็บใน public/images
    $file->move($destinationPath, $filename);

    $lastOrder = Slideshow::max('order') ?? 0;

    Slideshow::create([
        'order' => $lastOrder + 1,
        'path' => 'images/' . $filename  // เก็บ path ที่ต้องการ
    ]);

    return response()->json(['message' => 'เพิ่มสไลด์สำเร็จ!']);
}

public function update(Request $request, $id)
{
    // ตรวจสอบว่ามีไฟล์อัปโหลดหรือไม่
    if ($request->hasFile('slide')) {
        // ค้นหาสไลด์จากฐานข้อมูล
        $slide = Slideshow::findOrFail($id);

        // ลบไฟล์เก่าออกหากมี
        if ($slide->path && file_exists(public_path($slide->path))) {
            unlink(public_path($slide->path));
        }

        // อัปโหลดไฟล์ใหม่
        $file = $request->file('slide');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('images'); // เก็บใน public/images
        $file->move($destinationPath, $filename);

        $slide->path = 'images/' . $filename; // บันทึก path ใหม่

        // บันทึกการอัปเดต
        $slide->save();

        return response()->json(['message' => 'สไลด์ถูกอัปเดตแล้ว'], 200);
    }

    return response()->json(['message' => 'ไม่พบไฟล์ที่อัปโหลด'], 400);
}

    // ลบสไลด์
    public function destroy($id)
    {
        $slide = Slideshow::findOrFail($id);
        $oldImagePath = public_path($slide->path);
        if (File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }
        $slide->delete();
    
        return response()->json(['message' => 'ลบสไลด์สำเร็จ!']);
    }

}

