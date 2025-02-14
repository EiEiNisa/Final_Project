<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Rules\Captcha;

class UserController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prefix' => 'required|string',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:8|confirmed',
            'g-recaptcha-response' => ['required', new Captcha],
        ], [
            'prefix.required' => 'กรุณาเลือกคำนำหน้า',
            'name.required' => 'กรุณากรอกชื่อ',
            'surname.required' => 'กรุณากรอกนามสกุล',
            'username.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
            'username.unique' => 'ชื่อผู้ใช้งานนี้มีอยู่ในระบบแล้ว',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.unique' => 'อีเมลนี้มีอยู่ในระบบแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านยืนยันไม่ตรงกัน',
            'captcha' => 'กรุณายืนยันว่าไม่ใช่บอท',
        ]);

        $user = User::create([
            'prefix' => $request->prefix,
            'name' => $request->name,
            'surname' => $request->surname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'ผู้ใช้',
        ]);

        $adminEmails = ['nisawarabangsai300146@gmail.com', 'nisawara.ba@rmuti.ac.th'];

        if (in_array($user->email, $adminEmails)) {
            $user->role = 'แอดมิน';
            $user->save();
        }

        return redirect()->route('register.store')->with('success', 'ลงทะเบียนสำเร็จ เข้าสู่ระบบ');
    }


}
