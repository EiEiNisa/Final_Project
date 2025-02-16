<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
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
            'email' => 'required|email',
        ]);

        // ส่งลิงก์รีเซ็ตรหัสผ่านโดยใช้ Password::sendResetLink()
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        // ถ้าส่งลิงก์ได้สำเร็จ
        if ($status == Password::RESET_LINK_SENT) {
            // ส่งอีเมลด้วย view ที่คุณออกแบบเอง
            $user = \App\Models\User::where('email', $request->email)->first();

            // ส่งอีเมลที่ใช้ view ที่คุณสร้าง
            Mail::to($request->email)->send(new ResetPasswordMail($user));

            return back()->with('status', 'ลิงก์รีเซ็ตรหัสผ่านได้ถูกส่งไปยังอีเมลของคุณแล้ว');
        }
        
        return back()->with('error', 'ไม่พบอีเมลนี้ในระบบ');
    }
}
