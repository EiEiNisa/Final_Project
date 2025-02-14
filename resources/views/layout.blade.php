<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Permissions-Policy" content="accelerometer=(self), gyroscope=(self), device-orientation=(self)">

    <title>Thung Setthi Community</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    
    <style>
    body {
        background-color: #7DA7D8;
        font-family: 'Arial', sans-serif;
    }

    .logo {
        padding-right: 10px;
        width: 60px;
    }

    .navbar {
        background-color: #020364;
        padding: 15px 100px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 999;
        position: relative;
    }

    footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 400px;
        padding: 40px;
        background-color: #020364;
        color: #fff;
    }

    .no-underline-link {
        text-decoration: none;
        color: #fff;
    }
    </style>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <img class="logo" src="/logo.png" alt="Logo">
            <a class="navbar-brand" href="/" style="color: #fff; font-size:15px;">ชุมชนทุ่งเศรษฐี</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <form class="d-flex form-inline" style="padding-right:30px;">
                        <input class="form-control" type="search" style="width: 120%;" placeholder="ค้นหา"
                            aria-label="Search" name="query" required>
                    </form>
                    <li class="nav-item">
                        <a class="nav-link" href="/login" style="color: #fff;">เข้าสู่ระบบ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register" style="color: #fff;">ลงทะเบียน</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-2">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <div style="margin-left: 30px; color: #fff; line-height: 2;">
            <h4>ที่อยู่</h4>
            <p style="margin-left: 30px;">227/521 หมู่ 6 ถนนประชาสโมสร ตำบลในเมือง<br>อำเภอเมือง ขอนแก่น จังหวัดขอนแก่น
                40000</p>
            <h4>ช่องทางการติดต่อ</h4>
            <a href="https://www.facebook.com/profile.php?id=100089961199904"
                style="color: #fff; margin-left: 30px;">Facebook : จิตอาสา ชุมชน ทุ่งเศรษฐี </a><br>
            <a href="mailto:vlt227.521@gmail.com" style="color: #fff; margin-left: 30px;">Email :
                vlt227.521@gmail.com</a>
        </div>
        <iframe
            src="https://www.google.com/maps/embed?pb=!4v1732121802730!6m8!1m7!1sXVIYDk14khUq5Us2LVmU-A!2m2!1d16.43429993272521!2d102.8685188069868!3f105.96647009275887!4f11.296777919927024!5f0.7820865974627469"
            width="500" height="300" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </footer>
</body>
</html>