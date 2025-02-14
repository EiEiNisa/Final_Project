<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}