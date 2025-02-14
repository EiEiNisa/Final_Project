<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $imagePath = $request->file('image')->store('uploads', 'public');

        // สร้างบทความใหม่
        $article = new Article();
        $article->title = $request->input('title');
        $article->image = $imagePath;
        $article->description = $request->input('description');
        $article->post_date = $request->input('post_date');
        $article->author = $request->input('author');
        $article->save();

        return redirect()->route('submitform')->with('success', 'บทความถูกบันทึกสำเร็จ');
    }
}
