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
        $destinationPath = public_path('images');
        $file->move($destinationPath, $filename);

        $lastOrder = Slideshow::max('order') ?? 0;

        Slideshow::create([
            'order' => $lastOrder + 1,
            'path' => 'images/' . $filename
        ]);

        return response()->json(['message' => 'เพิ่มสไลด์สำเร็จ!']);
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

    // API สำหรับดึงข้อมูลสไลด์ทั้งหมด
    public function getSlides()
    {
        return response()->json(Slideshow::orderBy('order')->get());
    }
}

