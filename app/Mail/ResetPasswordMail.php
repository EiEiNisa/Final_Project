<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordMail extends Mailable
{
    public function showResetForm(Request $request)
    {
        // แสดงฟอร์มให้กรอกรหัสผ่านใหม่
        return view('reset-password', ['token' => $request->token]);
    }

    public function reset(Request $request)
    {
        // รีเซ็ตรหัสผ่านใหม่
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // ทำการรีเซ็ตรหัสผ่าน
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'รหัสผ่านของคุณได้ถูกรีเซ็ตรหัสแล้ว!');
        }

        return back()->withErrors(['email' => 'ไม่สามารถรีเซ็ตรหัสผ่านได้']);
    }
}