<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ResetPasswordMail;

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

    // ค้นหาผู้ใช้
    $user = User::where('email', $request->email)->first();

    // สร้าง Token เอง
    $token = Str::random(60);

    // บันทึก Token ลงในตาราง password_resets
    DB::table('password_resets')->updateOrInsert(
        ['email' => $user->email],
        [
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]
    );

    // ส่งอีเมลแบบ custom
    Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

    return back()->with('status', 'ลิงก์รีเซ็ตรหัสผ่านถูกส่งไปยังอีเมลของคุณแล้ว');
}
}