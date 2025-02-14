<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestEmail()
    {
        Mail::raw('ทดสอบการส่งอีเมลใน Laravel', function ($message) {
            $message->to('example@example.com') // ใส่อีเมลปลายทาง
                    ->subject('ทดสอบส่งอีเมล'); // กำหนดหัวข้อ
        });

        return "อีเมลถูกส่งเรียบร้อยแล้ว!";
    }
}
