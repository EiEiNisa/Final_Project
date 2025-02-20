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

    // อัปโหลดไฟล์ภาพไปยัง public/image
    $image = $request->file('image');
    $fileName = time() . '.' . $image->getClientOriginalExtension();
    $destinationPath = public_path('image');

    if (!$image->move($destinationPath, $fileName)) {
        return redirect()->back()->withErrors(['image' => 'การอัปโหลดรูปภาพล้มเหลว'])->withInput();
    }

    $imagePath = 'image/' . $fileName;

    // สร้างบทความใหม่
    $article = new Article();
    $article->title = $request->input('title');
    $article->image = $imagePath;
    $article->description = $request->input('description');
    $article->post_date = $request->input('post_date');
    $article->author = $request->input('author');

    if (!$article->save()) {
        return redirect()->back()->withErrors(['database' => 'การบันทึกบทความล้มเหลว'])->withInput();
    }

    return redirect()->route('admin.form.submit')->with('success', 'บทความถูกบันทึกสำเร็จ');
}


}