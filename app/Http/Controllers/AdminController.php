<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\RecordData;
use App\Models\HealthZone;
use App\Models\Disease;
use App\Models\ElderlyInformation;

class AdminController extends Controller
{
    public function manageUsers(Request $request)
{
    $user = session('register'); 

    if ($user->role !== 'แอดมิน') {
        return redirect()->route('home')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
    }

    $email = $request->input('email');
    $name = $request->input('name');

    $users = User::where('id', '!=', $user->id)
                ->when($email, function($query, $email) {
                    return $query->where('email', 'like', '%' . $email . '%');
                })
                ->when($name, function($query, $name) {
                    return $query->where(function($query) use ($name) {
                        $query->where('name', 'like', '%' . $name . '%')
                              ->orWhere('surname', 'like', '%' . $name . '%');
                    });
                })
                ->paginate(20);

    return view('admin.manageuser', compact('users'));
}


public function changeRole($id)
{

    $user = User::find($id);

    if (!$user) {
        return redirect()->route('admin.manageuser')->with('error', 'ไม่พบผู้ใช้นี้');
    }

    if ($user->role === 'ผู้ใช้') {
        $user->role = 'แอดมิน';
    } else {
        $user->role = 'ผู้ใช้';
    }
    
    $user->save();

    return redirect()->route('admin.manageuser')->with('success', 'สิทธิ์ของผู้ใช้ที่อีเมล ' . $user->email . ' ได้รับการเปลี่ยนแปลงเรียบร้อยแล้ว');
}


public function submitForm(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'images' => 'required|array',  // รองรับหลายไฟล์
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // กำหนดขนาดไฟล์ที่อนุญาต (ไม่เกิน 2MB)
        'video_link' => 'nullable|url', // กรอกลิงก์วิดีโอ
        'video_upload' => 'nullable|mimes:mp4,avi,mov,wmv|max:20480', // ไฟล์วิดีโอ
        'description' => 'required|string',
        'post_date' => 'required|date',
        'author' => 'required|string|max:255',
    ]);

    // บันทึกรูปภาพหลายไฟล์
    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            // ตรวจสอบขนาดไฟล์
            if ($image->getSize() > 2048 * 1024) { 
                return redirect()->back()->with('error', 'ขนาดไฟล์รูปภาพไม่สามารถเกิน 2MB');
            }
            $imagePaths[] = $image->store('images', 'public');
        }
    }

    // ถ้ามีไฟล์วิดีโอ ให้ทำการบันทึก
    $videoPath = $request->hasFile('video_upload') ? $request->file('video_upload')->store('videos', 'public') : null;
    
    // สร้างบทความใหม่
    Article::create([
        'title' => $request->input('title'),
        'image' => json_encode($imagePaths), // เก็บหลายไฟล์เป็น JSON
        'description' => $request->input('description'),
        'post_date' => $request->input('post_date'),
        'author' => $request->input('author'),
        'video_link' => $request->input('video_link'),  // ถ้ามีลิงก์วิดีโอให้ใช้ค่า
        'video_upload' => $videoPath,  // ถ้ามีไฟล์วิดีโอให้ใช้ค่า
    ]);

    return redirect()->route('admin.homepage')->with('success', 'บทความใหม่ได้ถูกเพิ่ม');
}


    public function showForm()
{
    return view('admin.form'); 
}

public function adminhomepage()
{
    $articles = Article::all(); 
    return view('admin.homepage', compact('articles'));
}


public function recordData()
{
    return $this->belongsTo(RecordData::class, 'recorddata_id');
}

public function homepage()
    {
        // หากคุณต้องการดึงข้อมูลบทความหรือข้อมูลอื่น ๆ ที่จะแสดงบนหน้า
        $articles = Article::all(); // หรือเปลี่ยนเป็นเงื่อนไขที่ต้องการ

        return view('admin.homepage', compact('articles')); // เปลี่ยนให้ตรงกับชื่อ view ที่คุณต้องการใช้
    }
}
