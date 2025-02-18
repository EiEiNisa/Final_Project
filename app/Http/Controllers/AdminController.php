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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
            'post_date' => 'required|date',
            'author' => 'required|string|max:255',
        ]);
    
        $imagePath = $request->file('image')->store('images', 'public');
    
        Article::create([
            'title' => $request->input('title'),
            'image' => $imagePath,
            'description' => $request->input('description'),
            'post_date' => $request->input('post_date'),
            'author' => $request->input('author'),
        ]);
    
        return redirect()->route('admin.homepage')->with('success', 'บทความใหม่ได้ถูกเพิ่ม');
    }


    public function showForm()
{
    return view('admin.form'); 
}

public function adminhomepage()
{
    return view('admin.homepage');
}


public function recordData()
{
    return $this->belongsTo(RecordData::class, 'recorddata_id');
}
}