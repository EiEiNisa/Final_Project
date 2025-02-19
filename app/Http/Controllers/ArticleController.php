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
        if ($page === 'User/homepage') {
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
    // ขั้นตอนที่ 1: Validate ข้อมูลจาก request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'post_date' => 'required|date',
        'author' => 'required|string|max:255',
        'images' => 'required|image|mimes:jpeg,png,gif|max:2048', // ตรวจสอบไฟล์ภาพ
    ]);

    // ขั้นตอนที่ 2: อัปโหลดไฟล์ภาพ
    if ($request->hasFile('images')) { 
        $imagePath = $request->file('images')->store('uploads', 'public');
        dd($imagePath); // ตรวจสอบ path ที่ได้
    } else {
        $imagePath = null; 
    }
    
    
    // ขั้นตอนที่ 3: สร้างบทความใหม่ในฐานข้อมูล
    Article::create([
        'title' => $validated['title'], // ใช้ค่าที่ผ่านการ validate
        'description' => $validated['description'],
        'post_date' => $validated['post_date'],
        'author' => $validated['author'],
        'images' => $imagePath, // เก็บที่อยู่ของไฟล์ภาพ
    ]);

    // ขั้นตอนที่ 4: เปลี่ยนเส้นทางไปยังหน้า admin homepage พร้อมกับข้อความสำเร็จ
    return redirect()->route('admin.homepage')->with('success', 'เพิ่มบทความสำเร็จ!');
}


    public function search(Request $request)
    {
        $query = $request->input('query');
    
        $articles = Article::where('title', 'like', $query . '%')->get();
    
        return view('search_results', compact('articles', 'query'));
    }
    

}