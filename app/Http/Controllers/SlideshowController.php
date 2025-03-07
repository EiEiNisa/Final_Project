<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;
use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{
  public function index()
{
    // ดึงข้อมูลสไลด์ทั้งหมดจากฐานข้อมูลและเรียงลำดับ
    $slides = Slideshow::orderBy('order')->get();

    // ตรวจสอบข้อมูลที่ได้
    if ($slides->isEmpty()) {
        // ถ้าไม่มีข้อมูล ให้แสดงข้อความหรือค่าที่ต้องการ
        \Log::info('ไม่มีสไลด์');
    } else {
        \Log::info('ข้อมูลสไลด์: ', $slides->toArray());
    }

    // ส่งข้อมูลไปยัง View
    return view('admin.addslide', compact('slides'));
}


    // เพิ่มสไลด์ใหม่
    public function store(Request $request)
    {
        $request->validate([
            'slide' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // อัปโหลดไฟล์
        $file = $request->file('slide');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('images'); // ใช้ public_path เพื่อชี้ไปที่โฟลเดอร์ public/images
        $file->move($destinationPath, $filename); // ย้ายไฟล์ไปยังโฟลเดอร์นี้

        // หาค่า order ถ้าไม่มีให้เริ่มจาก 1
        $lastOrder = Slideshow::max('order') ?? 0;

        // บันทึกข้อมูลสไลด์ใหม่
        Slideshow::create([
            'order' => $lastOrder + 1,
            'path' => 'images/' . $filename  // เก็บ path ที่ต้องการ
        ]);

        return response()->json(['message' => 'เพิ่มสไลด์สำเร็จ!']);
    }

    // อัปเดตสไลด์
    public function update(Request $request, $id)
    {
        // ตรวจสอบว่ามีไฟล์อัปโหลดหรือไม่
        if ($request->hasFile('slide')) {
            $slide = Slideshow::findOrFail($id);

            // ลบไฟล์เก่าออกหากมี
            if ($slide->path && file_exists(public_path($slide->path))) {
                unlink(public_path($slide->path));
            }

            // อัปโหลดไฟล์ใหม่
            $file = $request->file('slide');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images'); // ใช้ public_path เพื่อชี้ไปที่โฟลเดอร์ public/images
            $file->move($destinationPath, $filename); // ย้ายไฟล์ไปยังโฟลเดอร์นี้

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

        // ลบไฟล์เก่าออก
        if (file_exists(public_path($slide->path))) {
            unlink(public_path($slide->path));
        }

        // ลบข้อมูลสไลด์
        $slide->delete();
    
        return response()->json(['message' => 'ลบสไลด์สำเร็จ!']);
    }
}
