<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thung Setthi Community</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    }

    .navbar-brand,
    .nav-link {
        color: #fff !important;
    }

    .navbar-nav .nav-link {
        margin-right: 15px;
    }

    .navbar-toggler {
        border: none;
        /* ปิดขอบของปุ่ม */
    }

    .navbar-toggler-icon {
        background-color: white;
        /* เปลี่ยนสีของ hamburger icon เป็นสีขาว */
    }

    .footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 300px;
        padding: 40px;
        background-color: #020364;
        color: #fff;
    }

    @media (max-width: 576px) {
        .footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .footer div {
            margin-bottom: 20px;
        }
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <img class="logo" src="/logo.png" alt="Logo">
            <a class="navbar-brand" href="/User/homepage">ชุมชนทุ่งเศรษฐี</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/User/homepage">หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/User/record">บันทึกข้อมูล</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/User/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/User/about">ข้อมูลพื้นฐาน</a>
                    </li>
                </ul>
                <li class="nav-item" style="list-style-type: none;">
                    @if(session('register'))
                    <div class="dropdown" style="display: inline;">
                        <button class="nav-link dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <strong>{{ session('register')->username }}</strong>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li>
                                <a href="/user/editprofile" class="dropdown-item">แก้ไขโปรไฟล์</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">ออกจากระบบ</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endif
                </li>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div>
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div style="margin-left: 30px; color: #fff; line-height: 2;">
            <h4>ที่อยู่</h4>
            <p>227/521 หมู่ 6 ถนนประชาสโมสร ตำบลในเมือง<br>อำเภอเมืองขอนแก่น จังหวัดขอนแก่น 40000</p>
            <h4>ช่องทางการติดต่อ</h4>
            <a href="https://www.facebook.com/profile.php?id=100089961199904" style="color: #fff;">Facebook : จิตอาสา
                ชุมชม ทุ่งเศรษฐี</a><br>
            <a href="mailto:vlt227.521@gmail.com" style="color: #fff;">Email : vlt227.521@gmail.com</a>
        </div>

        <div>
            <h4>หน้าหลัก</h4>
            <a class="nav-link" href="/User/homepage" style="color: #fff;line-height: 2;">ข่าวกิจกรรม</a>
            <h4>Dashboard</h4>
            <a class="nav-link" href="/User/dashboard" style="color: #fff;line-height: 2;">สถิติกราฟข้อมูล</a>
        </div>

        <div>
            <h4>เกี่ยวกับเรา</h4>
            <a class="nav-link" href="/User/about" style="color: #fff;line-height: 2;">ข้อมูลพื้นฐานชุมชนทุ่งเศรษฐี</a>
        </div>

        <div>
            <h4>บันทึกข้อมูล</h4>
            <a class="nav-link" href="/User/recode" style="color: #fff;line-height: 2;">ข้อมูลสุขภาพ</a>
        </div>
    </footer>
</body>

</html>