<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;  // ใช้โมเดล Article 

class FormController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'required',
            'post_date' => 'required|date',
            'author' => 'required',
        ]);

        // อัปโหลดไฟล์ภาพไปยัง public/images โดยตรง
        $image = $request->file('image');
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('image'); // เก็บไฟล์ในโฟลเดอร์ public/images
        $image->move($destinationPath, $fileName); // ย้ายไฟล์ไปที่ public/images/

        $imagePath = $request->file('image')->store('uploads', 'public');
        // สร้างบทความใหม่
        $article = new Article();
        $article->title = $request->input('title');
        $article->image = $imagePath; // เก็บเส้นทางภาพในฐานข้อมูล
        $article->description = $request->input('description');
        $article->post_date = $request->input('post_date');
        $article->author = $request->input('author');
        $article->save();

        return redirect()->route('submitform')->with('success', 'บทความถูกบันทึกสำเร็จ');
    }
}