<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Password;

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
    $resetUrl = url('reset-password?token=' . $this->token . '&email=' . urlencode($this->user->email));

    return $this->subject('การรีเซ็ตรหัสผ่าน')
                ->view('resetpassword_link')
                ->with([
                    'userName' => $this->user->name,
                    'resetUrl' => $resetUrl,
                ]);
}

}
