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
    'video_upload' => 'nullable|mimes:mp4,avi,mov|max:50000', // ขนาดไฟล์วิดีโอไม่เกิน 20 MB
    'video_link' => 'nullable|url', // Validation สำหรับลิงก์ YouTube
], [
    'image.max' => 'ไฟล์รูปภาพใหญ่เกินไป กรุณาอัปโหลดไฟล์ที่มีขนาดไม่เกิน 2 MB',
    'video_upload.max' => 'ไฟล์วิดีโอใหญ่เกินไป กรุณาอัปโหลดไฟล์ที่มีขนาดไม่เกิน 50 MB',
]);


    if ($request->hasFile('image')) {
        $image = $request->file('image');

        // สร้างชื่อไฟล์ใหม่
        $fileName = time() . '.' . $image->getClientOriginalExtension();

        // จัดเก็บไฟล์ไว้ที่ public/images
        $destinationPath = public_path('images'); // กำหนดที่เก็บไฟล์
        $image->move($destinationPath, $fileName); // ย้ายไฟล์ไปที่ public/images

        // แปลง path เพื่อใช้ใน Blade
        $imageUrl = 'images/' . $fileName; 
    } else {
        return redirect()->back()->withErrors(['image' => 'กรุณาอัปโหลดรูปภาพ'])->withInput();
    }
        // อัปโหลดไฟล์วิดีโอ (ถ้ามี)
    $videoPath = null;
    if ($request->hasFile('video_upload')) {
        $video = $request->file('video_upload');
        $videoName = time() . '.' . $video->getClientOriginalExtension();
        $video->move(public_path('videos'), $videoName); // เก็บไฟล์วิดีโอในโฟลเดอร์ public/videos
        $videoPath = 'videos/' . $videoName;
    }
    
    // เก็บลิงก์วิดีโอจาก YouTube (ถ้ามี)
    $videoLink = $request->input('video_link'); // เก็บลิงก์ตรง ๆ ในฐานข้อมูล


    $article = new Article();
    $article->title = $request->input('title');
    $article->image = $imageUrl; // เส้นทางที่ใช้เรียกไฟล์ใน Blade
    $article->description = $request->input('description');
    $article->post_date = $request->input('post_date');
    $article->author = $request->input('author');
    $article->video_upload = $videoPath; // เก็บเส้นทางไฟล์วิดีโอ
    $article->video_link = $videoLink; // เก็บลิงก์ YouTube
    $article->save();
    
    return redirect()->route('submitform')->with('success', 'บทความถูกบันทึกสำเร็จ');
}
}
