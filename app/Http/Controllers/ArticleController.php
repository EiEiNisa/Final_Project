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
        'images' => 'required|array|min:1',  // ต้องมีการเลือกอย่างน้อย 1 ไฟล์
        'images.*' => 'image|mimes:jpeg,png,gif|max:2048',  // ตรวจสอบแต่ละไฟล์
        'video_link' => 'nullable|url',  // กรอกลิงก์วิดีโอ
        'video_upload' => 'nullable|mimes:mp4,avi,mov,wmv|max:20480',  // ไฟล์วิดีโอ
    ]);

    // การจัดการรูปภาพ (รองรับหลายไฟล์)
    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            // กำหนดชื่อไฟล์ใหม่เพื่อป้องกันการซ้ำ
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // ใช้ move เพื่อย้ายไฟล์ไปที่ public/image
            $destinationPath = public_path('image'); // โฟลเดอร์ที่ต้องการเก็บไฟล์
            $image->move($destinationPath, $fileName); // ย้ายไฟล์ไปยังโฟลเดอร์ public/image
            
            // เก็บพาธของไฟล์ (public/image/<fileName>)
            $imagePaths[] = 'image/' . $fileName;
        }
    }

    // สำหรับอัปโหลดไฟล์วิดีโอ
    $videoPath = null;
    if ($request->hasFile('video_upload')) {
        $videoFile = $request->file('video_upload');
        $videoFileName = time() . '.' . $videoFile->getClientOriginalExtension();
        $videoDestinationPath = public_path('videos');
        $videoFile->move($videoDestinationPath, $videoFileName);
        $videoPath = 'videos/' . $videoFileName;
    }

    // บันทึกข้อมูลบทความ
    Article::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'post_date' => $validated['post_date'],
        'author' => $validated['author'],
        'image' => json_encode($imagePaths),  // เก็บหลายไฟล์ในรูปแบบ JSON
        'video_link' => $validated['video_link'] ?? null,  // ถ้ามีลิงก์
        'video_upload' => $videoPath,  // ถ้ามีไฟล์
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
