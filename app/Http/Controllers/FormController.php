<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class FormController extends Controller
{
    public function store(Request $request)
{
    // เพิ่ม validation สำหรับไฟล์วิดีโอและลิงก์
    $request->validate([
        'title' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        'description' => 'required',
        'post_date' => 'required|date',
        'author' => 'required',
        'video_upload' => 'nullable|mimes:mp4,avi,mov', // Validation สำหรับไฟล์วิดีโอ
        'video_link' => 'nullable|url', // Validation สำหรับลิงก์ YouTube
    ]);
    
    // อัปโหลดไฟล์ภาพ
    $image = $request->file('image');
    $fileName = time() . '.' . $image->getClientOriginalExtension();
    $destinationPath = public_path('images'); // เก็บไฟล์ในโฟลเดอร์ public/images
    $image->move($destinationPath, $fileName); // ย้ายไฟล์ไปที่ public/images/
    
    $imagePath = 'images/' . $fileName; // เก็บเส้นทางในฐานข้อมูล
    
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

    // สร้างบทความใหม่
    $article = new Article();
    $article->title = $request->input('title');
    $article->image = $imagePath;
    $article->description = $request->input('description');
    $article->post_date = $request->input('post_date');
    $article->author = $request->input('author');
    $article->video_upload = $videoPath; // เก็บเส้นทางไฟล์วิดีโอ
    $article->video_link = $videoLink; // เก็บลิงก์ YouTube
    $article->save();
    
    return redirect()->route('submitform')->with('success', 'บทความถูกบันทึกสำเร็จ');
}

}
