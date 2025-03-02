<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    public $user;
    public $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        // ลิงก์ไปยังหน้า reset-password พร้อม Token
        $resetUrl = url('reset-password?token=' . $this->token . '&email=' . urlencode($this->user->email));

        dd($resetUrl);
        
        return $this->subject('การรีเซ็ตรหัสผ่าน')
                    ->view('resetpassword_link') // ใช้ View ที่สร้างเอง
                    ->with([
                        'userName' => $this->user->name,
                        'resetUrl' => $resetUrl,
                    ]);
    }
}