<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การรีเซ็ตรหัสผ่าน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #020364;
            text-align: center;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }

        footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }

        footer p {
            margin: 5px 0;
        }

        .contact-info {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .contact-info p {
            margin: 0;
            color: #333;
        }

        .contact-info strong {
            color: #020364;
        }

        .signature {
            font-style: italic;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>สวัสดี คุณ{{ $userName }}</h1>
    <p>คุณได้ขอรีเซ็ตรหัสผ่าน กรุณาคลิกลิงก์ด้านล่างเพื่อทำการรีเซ็ตรหัสผ่าน:</p>
    <p><a href="{{ $resetUrl }}">คลิกที่นี่เพื่อรีเซ็ตรหัสผ่าน</a></p>
    <p>หากคุณไม่ขอรีเซ็ตรหัสผ่าน โปรดละเลยอีเมลฉบับนี้</p>

    <hr>

    <div class="contact-info">
        <p>หากคุณประสบปัญหาหรือมีคำถามเพิ่มเติมเกี่ยวกับการรีเซ็ตรหัสผ่าน, กรุณาติดต่อเราได้ที่อีเมล <strong> vlt227.521@gmail.com</strong></p>
    </div>

    <footer>
        <p>ทีมงาน อสม. บ้านทุ่งเศรษฐี</p>
    </footer>

    <div class="signature">
        <p>ด้วยความเคารพ,</p>
        <p>ทีมงาน อสม. บ้านทุ่งเศรษฐี</p>
    </div>
</body>
</html>
