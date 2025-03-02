<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
{
    return view('reset-password', [
        'token' => $request->query('token'),
        'email' => $request->query('email')
    ]);
}

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านยืนยันไม่ตรงกัน',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );
    
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'รหัสผ่านของคุณถูกรีเซ็ตเรียบร้อยแล้ว ตอนนี้คุณสามารถเข้าสู่ระบบได้');
        }
    
        return back()->withErrors(['email' => __($status)]);
}
}