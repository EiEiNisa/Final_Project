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
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // ขนาดสูงสุด 2 MB
        'description' => 'required',
        'post_date' => 'required|date',
        'author' => 'required',
    ], [
        'image.max' => 'ไฟล์รูปภาพใหญ่เกินไป กรุณาอัปโหลดไฟล์ที่มีขนาดไม่เกิน 2 MB'
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

    $article = new Article();
    $article->title = $request->input('title');
    $article->image = $imageUrl; // เส้นทางที่ใช้เรียกไฟล์ใน Blade
    $article->description = $request->input('description');
    $article->post_date = $request->input('post_date');
    $article->author = $request->input('author');

    if (!$article->save()) {
        return redirect()->back()->withErrors(['database' => 'การบันทึกบทความล้มเหลว'])->withInput();
    }

    return redirect()->route('admin.homepage')->with('success', 'บทความถูกบันทึกสำเร็จ');
}



}