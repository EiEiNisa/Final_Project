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
    ]);

    // เช็คว่ามีไฟล์ภาพถูกอัปโหลดมาหรือไม่
    if (!$request->hasFile('image')) {
        return redirect()->back()->withErrors(['image' => 'กรุณาอัปโหลดรูปภาพ'])->withInput();
    }

    $image = $request->file('image');

    // เช็คว่าไฟล์อัปโหลดถูกต้อง
    if (!$image->isValid()) {
        return redirect()->back()->withErrors(['image' => 'ไฟล์รูปภาพไม่ถูกต้อง'])->withInput();
    }

    // สร้างชื่อไฟล์ใหม่
    $fileName = time() . '.' . $image->getClientOriginalExtension();

    // จัดเก็บไฟล์ไว้ที่ storage/app/public/images
    $imagePath = $image->storeAs('public/images', $fileName);

    // แปลง path ให้สามารถเรียกใช้งานผ่าน storage link (ลบ 'public/' ออก)
    $imagePath = str_replace('public/', 'storage/', $imagePath);

    // บันทึกข้อมูลบทความลงฐานข้อมูล
    $article = new Article();
    $article->title = $request->input('title');
    $article->image = $imagePath; // เส้นทางที่ใช้เรียกไฟล์ใน Blade
    $article->description = $request->input('description');
    $article->post_date = $request->input('post_date');
    $article->author = $request->input('author');

    if (!$article->save()) {
        return redirect()->back()->withErrors(['database' => 'การบันทึกบทความล้มเหลว'])->withInput();
    }

    return redirect()->route('admin.homepage')->with('success', 'บทความถูกบันทึกสำเร็จ');
}

}