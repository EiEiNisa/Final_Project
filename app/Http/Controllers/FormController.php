<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;  // ใช้โมเดล Article 
use Illuminate\Support\Facades\File; // เพิ่มการใช้งาน Facade File

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

        // อัพโหลดไฟล์ภาพ
        $imagePath = null;
        if ($request->hasFile('image')) {
            // กำหนดชื่อไฟล์
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName(); // ตั้งชื่อไฟล์ให้ไม่ซ้ำ
            $destinationPath = public_path('images'); // กำหนดเส้นทางที่ต้องการเก็บไฟล์
            
            // ย้ายไฟล์ไปยัง public/images/
            $request->file('image')->move($destinationPath, $fileName);
            $imagePath = 'images/' . $fileName; // กำหนดเส้นทางของภาพที่บันทึกในฐานข้อมูล
        }

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
