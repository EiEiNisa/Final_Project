<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;
use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{
    public function index()
{
    $slides = Slideshow::orderBy('order')->get(); // ดึงข้อมูลสไลด์จากฐานข้อมูล
    
    return view('admin.addslide', compact('slides'));
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
public function delete($id)
{
    // หาข้อมูลสไลด์จากฐานข้อมูล
    $slide = Slide::findOrFail($id);

    // ลบไฟล์รูปภาพจากโฟลเดอร์ public/images
    $filePath = public_path('images/' . $slide->path);
    if (File::exists($filePath)) {
        File::delete($filePath); // ลบไฟล์
    }

    // ลบข้อมูลสไลด์จากฐานข้อมูล
    $slide->delete();

    return redirect()->route('addslide')->with('success', 'ลบสไลด์สำเร็จ');
}    
}
