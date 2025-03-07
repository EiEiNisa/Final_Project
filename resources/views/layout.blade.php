<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Permissions-Policy" content="accelerometer=(self), gyroscope=(self), device-orientation=(self)">
    <title>Thung Setthi Community</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">

    <!-- Bootstrap JS (ไม่ต้องใช้ integrity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Poppins:wght@300;400;600&family=Sarabun:wght@300;400;600&display=swap');

    body {
        background-color: #7DA7D8;
        font-family: 'Poppins';
        font-size: 14px;
    }

    .logo {
        padding-right: 10px;
        width: 60px;
    }

    .navbar {
        background-color: #020364;
        padding: 15px 40px;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-color: white;
    }

    footer {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: space-between;
        height: auto;
        background-color: #020364;
        color: #fff;
    }

    .no-underline-link {
        text-decoration: none;
        color: #fff;
    }

    @media (min-width: 768px) {
        footer {
            flex-direction: row;
        }
    }

    .footer-col {
        margin-bottom: 30px;
    }

    .footer-col h4 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .footer-col a {
        color: #fff;
        text-decoration: none;
    }

    .footer-col a:hover {
        text-decoration: underline;
    }

    footer iframe {
        width: 100%;
        height: 300px;
        max-width: 500px;
        margin: 0 auto;
        display: block;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <img class="logo" src="/logo.png" alt="Logo">
            <a class="navbar-brand" href="/" style="color: #fff; font-size:15px;">ชุมชนทุ่งเศรษฐี</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <form class="d-flex" style="padding-right:30px;" action="{{ route('search') }}" method="GET">
                        <br>
                        <input class="form-control me-2" type="search" placeholder="ค้นหาบทความ..." aria-label="Search"
                            name="query" required>
                        <button class="btn btn-light ms-2" type="submit">ค้นหา</button>
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

    <!-- footer -->
    <footer>
        <!-- Grid container -->
        <div class="container p-4">
            <!--Grid row-->
            <div class="row my-4">
                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

                    <div class="d-flex align-items-center justify-content-center mb-4 mx-auto">
                        <img src="/logo.png" alt="Logo" loading="Logo" style="width: 300px; height: 300px;"/>
                    </div>

                    <p class="text-center" style="font-size: 15px;">อาสาสมัครสาธารณสุข ประจำหมู่บ้านทุ่งเศรษฐี</p>

                    <ul class="list-unstyled d-flex flex-row justify-content-center">
                        <li>
                            <a class="text-white px-2" href="https://www.facebook.com/profile.php?id=100089961199904">
                                <i class="fab fa-facebook-square"></i>
                            </a>
                        </li>
                        <li>
                            <a class="text-white px-2" href="mailto:vlt227.521@gmail.com">
                                <i class="fab fa-google-plus-g"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">เมนู</h5>

                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="/login" class="text-white" style="font-size: 15px;">เข้าสู่ระบบ</a>
                        </li>
                        <li class="mb-2">
                            <a href="/register" class="text-white" style="font-size: 15px;">ลงทะเบียน</a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">ช่องทางการติดต่อ</h5>

                    <ul class="list-unstyled">
                        <li>
                            <p><i class="fas fa-map-marker-alt pe-2" style="font-size: 15px;"></i>227/521 หมู่ 6 ถนนประชาสโมสร
                                ตำบลในเมือง<br>อำเภอเมือง ขอนแก่น จังหวัดขอนแก่น 40000</p>
                        </li>
                        <li>
                            <p><i class="fas fa-envelope pe-2 mb-0"style="font-size: 15px;"></i>vlt227.521@gmail.com</p>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">แผนที่</h5>

                    <ul class="list-unstyled">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!4v1732121802730!6m8!1m7!1sXVIYDk14khUq5Us2LVmU-A!2m2!1d16.43429993272521!2d102.8685188069868!3f105.96647009275887!4f11.296777919927024!5f0.7820865974627469"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    </div>

</body>

</html>