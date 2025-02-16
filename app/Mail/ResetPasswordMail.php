<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('การรีเซ็ตรหัสผ่าน')
                    ->view('resetpassword_link')  // ใช้ view ที่คุณสร้าง
                    ->with([
                        'userName' => $this->user->name,
                        'resetUrl' => url('password/reset/'.$this->user->email), // แทนที่ด้วยลิงก์รีเซ็ตรหัสผ่านที่ถูกต้อง
                    ]);
    }
}
