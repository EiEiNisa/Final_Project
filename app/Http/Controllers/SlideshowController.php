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
        $slides = \App\Models\Slideshow::orderBy('order')->get();
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
        $destinationPath = public_path('images');
        $file->move($destinationPath, $filename);

        // ตรวจสอบลำดับการเพิ่มสไลด์
        $lastOrder = Slideshow::max('order') ?? 0;

        Slideshow::create([
            'order' => $lastOrder + 1,
            'path' => 'images/' . $filename, // ควรเก็บ path ที่มีชื่อ folder
        ]);

        return back()->with('success', 'เพิ่มสไลด์สำเร็จ!');
    }

    // อัปเดตสไลด์
    public function update(Request $request, $id)
    {
        $request->validate([
            'slide' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $slide = Slideshow::findOrFail($id);

        // ลบไฟล์เก่า
        $oldImagePath = public_path($slide->path);
        if (File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }

        // อัปโหลดไฟล์ใหม่
        $file = $request->file('slide');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('images');
        $file->move($destinationPath, $filename);

        // อัปเดตข้อมูล path ของสไลด์
        $slide->update(['path' => 'images/' . $filename]);

        return back()->with('success', 'อัปโหลดสไลด์สำเร็จ!');
    }

    // ลบสไลด์
    public function destroy($id)
    {
        $slide = Slideshow::findOrFail($id);
        
        // ลบไฟล์จาก public/images
        $oldImagePath = public_path($slide->path);
        if (File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }

        // ลบข้อมูลในฐานข้อมูล
        $slide->delete();
    
        return response()->json(['message' => 'ลบสไลด์สำเร็จ!']);
    }
}
