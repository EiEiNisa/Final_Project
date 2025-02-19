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
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'post_date' => 'required|date',
        'author' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,gif|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads');  // เปลี่ยนเป็น public/uploads
        $file->move($destinationPath, $fileName);  // ย้ายไฟล์ไปที่ public/uploads/
        $imagePath = 'uploads/' . $fileName; // เก็บเส้นทางไฟล์ในฐานข้อมูล
    }

    // บันทึกข้อมูลบทความ
    Article::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'post_date' => $validated['post_date'],
        'author' => $validated['author'],
        'image' => $imagePath,
    ]);

    return redirect()->route('admin.homepage')->with('success', 'เพิ่มบทความสำเร็จ!');
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