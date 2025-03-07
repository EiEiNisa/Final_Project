<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;
use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{
    public function index()
{
    // ดึงข้อมูลทั้งหมดของสไลด์จากฐานข้อมูล
    $slides = Slideshow::orderBy('order')->get();

    // ส่งตัวแปร $slides ไปยัง view
    return view('admin.slideshow', compact('slides'));
}

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
        'path' => 'images/' . $filename,
    ]);

    return redirect()->route('slideshow.index');
}

public function update(Request $request, $id)
{
    if ($request->hasFile('slide')) {
        $slide = Slideshow::findOrFail($id);

        if ($slide->path && file_exists(public_path($slide->path))) {
            unlink(public_path($slide->path));
        }

        $file = $request->file('slide');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('images');
        $file->move($destinationPath, $filename);

        $slide->path = 'images/' . $filename;
        $slide->save();
    }

    return redirect()->route('slideshow.index');
}

public function destroy($id)
{
    $slide = Slideshow::findOrFail($id);
    $oldImagePath = public_path($slide->path);

    if (file_exists($oldImagePath)) {
        unlink($oldImagePath);
    }

    $slide->delete();

    return redirect()->route('slideshow.index');
}

}
