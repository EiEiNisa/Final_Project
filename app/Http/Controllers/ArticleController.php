<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index($page = 'home')
    {
        $articles = Article::all(); 

        if ($page === 'admin/homepage') {
            return view('admin.homepage', compact('articles'));
        }
        if ($page === 'user/homepage') {
            return view('user.homepage', compact('articles'));
        }

        return view('home', compact('articles'));
    }
    
    public function destroy($id)
{
    $article = Article::findOrFail($id);
    $article->delete();

    return redirect()->route('admin.homepage')->with('success', 'บทความถูกลบเรียบร้อยแล้ว');
}

public function show($id)
{
    $article = Article::findOrFail($id);
        return view('admin.article', compact('article'));
}
    public function create()
    {
        return view('/admin/form');
    }
    
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        'description' => 'required',
        'post_date' => 'required|date',
        'author' => 'required',
    ]);

    // อัพโหลดไฟล์ภาพไปที่ public/uploads
    $imagePath = $request->file('image')->store('uploads', 'public'); // เก็บใน 'uploads'

    // สร้างบทความใหม่
    $article = new Article();
    $article->title = $request->input('title');
    $article->image = $imagePath; // เก็บเส้นทางที่ถูกต้อง
    $article->description = $request->input('description');
    $article->post_date = $request->input('post_date');
    $article->author = $request->input('author');
    $article->save();

    return redirect()->route('submitform')->with('success', 'บทความถูกบันทึกสำเร็จ');
}

    public function search(Request $request)
    {
        // รับค่า query จากผู้ใช้
        $query = $request->input('query');
    
        // ค้นหาบทความที่ชื่อขึ้นต้นด้วยคำที่กรอก
        $articles = Article::where('title', 'like', $query . '%')->get();
    
        // ส่งข้อมูลผลลัพธ์ไปยังหน้าแสดงผล
        return view('search_results', compact('articles', 'query'));
    }
    

}