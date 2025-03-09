<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class FormController extends Controller
{
    public function store(Request $request) 
    {
        // Validation สำหรับฟอร์ม
        $request->validate([
            'title' => 'required',
            'images' => 'required|array|min:1', // ต้องมีการเลือกอย่างน้อย 1 ไฟล์
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // ตรวจสอบแต่ละไฟล์
            'description' => 'required',
            'post_date' => 'required|date',
            'author' => 'required',
            'video_upload' => 'nullable|mimes:mp4,avi,mov|max:50000', // ขนาดไฟล์วิดีโอไม่เกิน 50 MB
            'video_link' => 'nullable|url', // Validation สำหรับลิงก์ YouTube
        ], [
            'images.max' => 'ไฟล์รูปภาพใหญ่เกินไป กรุณาอัปโหลดไฟล์ที่มีขนาดไม่เกิน 2 MB',
            'video_upload.max' => 'ไฟล์วิดีโอใหญ่เกินไป กรุณาอัปโหลดไฟล์ที่มีขนาดไม่เกิน 50 MB',
            'video_upload.mimes' => 'ไฟล์วิดีโอต้องเป็น mp4, avi หรือ mov เท่านั้น'
        ]);

        // ✅ การจัดการรูปภาพหลายไฟล์
        if ($request->hasFile('images')) {
            $images = $request->file('images'); // 👉 รับไฟล์หลายไฟล์
            $imageUrls = []; // 👉 เก็บพาธของไฟล์ทั้งหมด

            foreach ($images as $image) {
                // ✅ สร้างชื่อไฟล์ใหม่
                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // ✅ ย้ายไฟล์ไปยัง public/images/
                $image->move(public_path('images'), $fileName); // เก็บไฟล์ในโฟลเดอร์ public/images/

                // ✅ เก็บพาธของไฟล์
                $imageUrls[] = 'images/' . $fileName; // เก็บเส้นทางไว้ในรูปแบบที่ Laravel รองรับ
            }
        } else {
            return redirect()->back()->withErrors(['images' => 'กรุณาอัปโหลดรูปภาพ'])->withInput();
        }

        // ✅ การจัดการไฟล์วิดีโอ
        $videoPath = null;
        if ($request->hasFile('video_upload')) {
            $video = $request->file('video_upload');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $videoPath = $video->storeAs('videos', $videoName, 'public'); // เก็บไฟล์ในโฟลเดอร์ public/videos
        }

        // ✅ เก็บลิงก์วิดีโอจาก YouTube (ถ้ามี)
        $videoLink = $request->input('video_link');

        // ✅ บันทึกข้อมูลบทความ
        $article = new Article();
        $article->title = $request->input('title');
        $article->image = json_encode($imageUrls); // ✅ เก็บหลายภาพเป็น JSON
        $article->description = $request->input('description');
        $article->post_date = $request->input('post_date');
        $article->author = $request->input('author');
        $article->video_upload = $videoPath; 
        $article->video_link = $videoLink;
        $article->save();

        return redirect()->route('admin.homepage')->with('success', 'บทความถูกบันทึกสำเร็จ');
    }
}
