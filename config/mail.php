<?php

return [

    'default' => env('MAIL_MAILER', 'smtp'),

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.gmail.com'), // ใช้ smtp.gmail.com
            'port' => env('MAIL_PORT', 587), // พอร์ตของ Gmail คือ 587
            'encryption' => env('MAIL_ENCRYPTION', 'tls'), // Gmail ใช้ TLS
            'username' => env('MAIL_USERNAME'), // อีเมลผู้ใช้ (ดึงจาก .env)
            'password' => env('MAIL_PASSWORD'), // App Password (ดึงจาก .env)
            'timeout' => null,
            'auth_mode' => null,
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'example@example.com'), // อีเมลผู้ส่ง
        'name' => env('MAIL_FROM_NAME', 'Example'), // ชื่อผู้ส่ง
    ],

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];

