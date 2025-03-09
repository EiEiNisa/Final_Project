<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;
use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{
    public function index()
{
    // ดึงข้อมูลทั้งหมดจากฐานข้อมูล โดยเรียงตาม 'order'
    $slides = Slideshow::orderBy('order')->get();  // ดึงข้อมูลสไลด์ทั้งหมดที่จัดเรียงตาม 'order'
// ตรวจสอบว่าเป็นหน้า 'admin/homepage'
    if ($page === 'admin/homepage') {
        return view('admin.homepage', compact('slides'));
    }

    // ตรวจสอบว่าเป็นหน้า 'user/homepage'
    if ($page === 'user/homepage') {
        return view('user.homepage', compact('slides'));
    }

    // ถ้าไม่ใช่หน้า 'admin/homepage' หรือ 'user/homepage' จะโหลดหน้า home
    return view('home', compact('slides'));
}
    
    public function store(Request $request)
{
    $request->validate([
        'slide' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $file = $request->file('slide');
    $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // ใช้ uniqid()
    $destinationPath = public_path('images');
    $file->move($destinationPath, $filename);

    $lastOrder = Slideshow::max('order') ?? 0;

    Slideshow::create([
        'order' => $lastOrder + 1,
        'path' => 'images/' . $filename,
    ]);

    return redirect()->route('addslide');
}

public function update(Request $request, $id)
{
    $slide = Slideshow::findOrFail($id);

    if ($request->hasFile('slide')) {
        if ($slide->path && file_exists(public_path($slide->path))) {
            unlink(public_path($slide->path));
        }

        $file = $request->file('slide');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // ใช้ uniqid()
        $destinationPath = public_path('images');
        $file->move($destinationPath, $filename);

        $slide->path = 'images/' . $filename;
        $slide->save();
    }

    return redirect()->route('addslide');
}

public function destroy($id)
{
    $slide = Slideshow::findOrFail($id);
    $oldImagePath = public_path($slide->path);

    if (file_exists($oldImagePath)) {
        unlink($oldImagePath);
    }

    $slide->delete();

    return redirect()->route('addslide');
}


}
