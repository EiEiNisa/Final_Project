<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    // ค้นหาผู้ใช้ตามอีเมล
    $user = Users::where('email', $request->email)->first();

    // สร้าง Token ใหม่
    $token = Str::random(60);
    
    // บันทึก Token ไว้ในตาราง password_resets
    \DB::table('password_resets')->updateOrInsert(
        ['email' => $user->email],
        [
            'email' => $user->email,
            'token' => bcrypt($token), 
            'created_at' => now(),
        ]
    );

    // ส่งอีเมลรีเซ็ตรหัสผ่านที่กำหนดเอง
    Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

    return back()->with('status', 'ลิงก์รีเซ็ตรหัสผ่านถูกส่งไปยังอีเมลของคุณแล้ว');
}

}
