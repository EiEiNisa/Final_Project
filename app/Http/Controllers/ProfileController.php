<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
{
    $user = session('register');

    if (!$user) {
        return redirect()->route('login.form')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
    }

    if ($user->role == 'แอดมิน') {
        //dd(view('admin.editprofile')); 
        return view('admin.editprofile', compact('user'));
    } else {
        //dd(view('user.editprofile')); 
        return view('user.editprofile', compact('user'));
    }
}


    public function update(Request $request)
    {
        $user = session('register');

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($user->role == 'แอดมิน') {
            return redirect()->route('admin.editprofile')->with('success', 'อัปเดตข้อมูลสำเร็จ');
        } else {
            return redirect()->route('user.editprofile')->with('success', 'อัปเดตข้อมูลสำเร็จ');
        }
        
    }
}
