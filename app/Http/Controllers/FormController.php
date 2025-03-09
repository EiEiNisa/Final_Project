<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class FormController extends Controller
{
  public function store(Request $request) 
{
    $request->validate([
        'title' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required',
        'post_date' => 'required|date',
        'author' => 'required',
        'video_upload' => 'nullable|mimes:mp4,avi,mov|max:50000', // ขนาดไฟล์วิดีโอไม่เกิน 50 MB
        'video_link' => 'nullable|url', // Validation สำหรับลิงก์ YouTube
    ], [
        'image.max' => 'ไฟล์รูปภาพใหญ่เกินไป กรุณาอัปโหลดไฟล์ที่มีขนาดไม่เกิน 2 MB',
        'video_upload.max' => 'ไฟล์วิดีโอใหญ่เกินไป กรุณาอัปโหลดไฟล์ที่มีขนาดไม่เกิน 50 MB',
        'video_upload.mimes' => 'ไฟล์วิดีโอต้องเป็น mp4, avi หรือ mov เท่านั้น'
    ]);

    // การจัดการรูปภาพ
    if ($request->hasFile('image')) {
        $image = $request->file('image');

        // ตรวจสอบขนาดไฟล์ (ไม่เกิน 2MB)
        if ($image->getSize() > 2048 * 1024) { 
            return redirect()->back()->withErrors(['image' => 'ไฟล์รูปภาพใหญ่เกินไป กรุณาอัปโหลดไฟล์ที่มีขนาดไม่เกิน 2 MB'])->withInput();
        }

        // สร้างชื่อไฟล์ใหม่
        $fileName = time() . '.' . $image->getClientOriginalExtension();

        // จัดเก็บไฟล์ไว้ที่ public/images
        $destinationPath = public_path('images');
        $image->move($destinationPath, $fileName);

        // แปลง path เพื่อใช้ใน Blade
        $imageUrl = 'images/' . $fileName;
    } else {
        return redirect()->back()->withErrors(['image' => 'กรุณาอัปโหลดรูปภาพ'])->withInput();
    }

    // การจัดการไฟล์วิดีโอ
    if ($request->hasFile('video_upload')) {
        $video = $request->file('video_upload');
        $maxSize = 50000 * 1024;  // ขนาดสูงสุด 50 MB

        // ตรวจสอบขนาดไฟล์วิดีโอ
        if ($video->getSize() > $maxSize) {
            return redirect()->back()->withErrors(['video_upload' => 'ไฟล์วิดีโอใหญ่เกินไป (สูงสุด 50MB)'])->withInput();
        }

        // สร้างชื่อไฟล์ใหม่
        $videoName = time() . '.' . $video->getClientOriginalExtension();

        // บันทึกไฟล์ลงในโฟลเดอร์ public/videos
        $video->move(public_path('videos'), $videoName);

        // เก็บพาธของไฟล์
        $videoPath = 'videos/' . $videoName;
    } else {
        $videoPath = null;
    }

    // เก็บลิงก์วิดีโอจาก YouTube (ถ้ามี)
    $videoLink = $request->input('video_link');

    // บันทึกข้อมูลบทความ
    $article = new Article();
    $article->title = $request->input('title');
    $article->image = $imageUrl; // เส้นทางที่ใช้เรียกไฟล์ใน Blade
    $article->description = $request->input('description');
    $article->post_date = $request->input('post_date');
    $article->author = $request->input('author');
    $article->video_upload = $videoPath; // เก็บเส้นทางไฟล์วิดีโอ
    $article->video_link = $videoLink; // เก็บลิงก์ YouTube
    $article->save();

    return redirect()->route('admin.homepage')->with('success', 'บทความถูกบันทึกสำเร็จ');
}

}
