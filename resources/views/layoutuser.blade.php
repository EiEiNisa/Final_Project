<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thung Setthi Community</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS (และ Popper.js สำหรับบางฟังก์ชัน) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

    .navbar .dropdown {
        position: relative;
    }

    .navbar .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #fff;
        color: #000;
        border: none;
        z-index: 1000;
        width: 180px;
        max-width: 100%;
        max-height: 150px;
        overflow-y: auto;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        padding: 10px 0;
    }

    .navbar .dropdown-item {
        padding: 8px 16px;
        font-size: 14px;
        white-space: nowrap;
    }


    footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 300px;
        padding: 40px;
        background-color: #020364;
        color: #fff;
    }
    </style>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <img class="logo" src="/logo.png" alt="Logo">
            <a class="navbar-brand" href="/User/homepage" style="color: #fff; font-size:15px;">ชุมชนทุ่งเศรษฐี</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/User/homepage" style="color: #fff;">หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/User/record" style="color: #fff;">บันทึกข้อมูล</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/User/dashboard" style="color: #fff;">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/User/about" style="color: #fff;">ข้อมูลพื้นฐาน</a>
                    </li>
                </ul>
            </div>

            <li class="nav-item" style="list-style-type: none;">
                @if(session('register'))
                <div class="dropdown" style="display: inline;">
                    <button class="nav-link dropdown-toggle"
                        style="color: #FEFB18; padding-left: 10px; text-decoration: none; display: inline;"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>{{ session('register')->username }}</strong>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li>
                            <a href="/User/editprofile" class="dropdown-item">แก้ไขโปรไฟล์</a>
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
    </nav>

    <!-- Content -->
    <div>
        @yield('content')
    </div>

    <!-- Footer -->
    <footer style="display: flex; flex-direction: row">
        <div style="margin-left: 30px; color: #fff; line-height: 2;">
            <h4>ที่อยู่</h4>
            <p style="margin-left: 30px;">227/521 หมู่ 6 ถนนประชาสโมสร ตำบลในเมือง<br>อำเภอเมืองขอนแก่น จังหวัดขอนแก่น
                40000</p>
            <h4>ช่องทางการติดต่อ</h4>
            <a href="https://www.facebook.com/profile.php?id=100089961199904"
                style="color: #fff; margin-left: 30px;">Facebook : จิตอาสา ชุมชม
                ทุ่งเศรษฐี</a><br>
            <a href="mailto:vlt227.521@gmail.com" style="color: #fff; margin-left: 30px;">Email :
                vlt227.521@gmail.com</a>
        </div>

        <div>
            <h4>หน้าหลัก</h4>
            <a class="nav-link" href="/User/homepage" style="color: #fff;line-height: 2;">ข่าวกิจกรรม</a>
            <br>
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