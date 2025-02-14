<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Captcha implements Rule
{
    public function passes($attribute, $value)
    {
        // ตรวจสอบการเชื่อมต่อกับ Google reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRETKEY'),
            'response' => $value,
        ]);

        // ถ้าผลลัพธ์จาก Google reCAPTCHA เป็น true, จะส่งคืน true
        return $response->json()['success'];
    }

    public function message()
    {
        return 'กรุณายืนยันว่าไม่ใช่บอท';
    }
}
