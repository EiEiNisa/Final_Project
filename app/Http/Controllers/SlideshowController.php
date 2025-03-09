<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;
use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{
    public function index()
    {
        $slides = Slideshow::orderBy('order')->get(); 
        
    $adminView = view('admin.addslide', compact('slides'))->render();

        // ส่งข้อมูลไปยังหน้า userhomepage และ home
        return view('User.homepage', compact('slides')) // หน้าสำหรับผู้ใช้
                ->with('adminView', $adminView) // ส่งตัวแปร $adminView ไปที่หน้า userhomepage
                ->with('home', $adminView);
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
