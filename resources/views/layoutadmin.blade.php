<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Permissions-Policy" content="accelerometer=(self)">
    <title>Thung Setthi Community</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS (และ Popper.js สำหรับบางฟังก์ชัน) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #7DA7D8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
    
        .navbar {
            background-color: #020364;
            color: #fff;
            padding: 10px;
        }
    
        .sidebar {
            width: 200px;
            background-color: #020364;
            padding: 30px;
            position: fixed;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 100;
        }
    
        .sidebar a {
            color: #fff;
            display: block;
            text-decoration: none;
            padding: 15px;
            font-size: 20px;
            margin-bottom: 15px;
        }
    
        .sidebar a:hover {
            background-color: #6D91C9;
        }
    
        .content {
            margin-left: 200px;
            padding: 10px;
            flex-grow: 1;
            max-width: 100%;;
        }
        footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            background-color: #020364;
            color: #fff;
            padding: 20px;
            margin-top: auto;
            margin-left: 200px;
        }
    
        footer div {
            flex: 1;
            min-width: 200px;
            margin: 10px;
            font-size: 17px;
        }
    
        footer h5 {
            margin-bottom: 20px;
            font-size: 18px;
        }
    
        footer a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
    
        footer p {
            margin: 5px 0;
        }
    
        .user-dropdown {
            color: #FEFB18;
            padding-left: 10px;
            text-decoration: none;
        }
    
        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
                text-align: center;
                padding: 10px 0;
            }
    
            .sidebar a {
                display: inline-block;
                margin: 5px 10px;
            }
    
            .content {
                margin-left: 0;
                padding: 5px;
                max-width: 100%;
            }
    
            footer {
                flex-direction: column;
                margin-left: 0;
                text-align: center;
            }
        }
    </style>    
    
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/admin/homepage">ชุมชนทุ่งเศรษฐี</a>
            @if(session('register'))
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle user-dropdown" type="button" id="userDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <strong>{{ session('register')->username }}</strong>
                </button>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">ออกจากระบบ</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <img class="logo" src="/logo.png" alt="Logo" width="100">
        <a href="/admin/homepage">หน้าหลัก</a>
        <a href="/admin/record">บันทึกข้อมูล</a>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/about">ข้อมูลพื้นฐาน</a>
        <a href="/admin/form">เพิ่มบทความ</a>
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <div>
            <h5>ที่อยู่</h5>
            <p>227/521 หมู่ 6 ถนนประชาสโมสร ตำบลในเมือง<br>อำเภอเมืองขอนแก่น จังหวัดขอนแก่น 40000</p>
        </div>
        <div>
            <h5>ช่องทางการติดต่อ</h5>
            <a href="https://www.facebook.com/profile.php?id=100089961199904">Facebook : จิตอาสา ชุมชน ทุ่งเศรษฐี</a>
            <a href="mailto:vlt227.521@gmail.com">Email : vlt227.521@gmail.com</a>
        </div>
    
        <div>
            <h5>หน้าหลัก</h5>
            <a href="/admin/homepage">ข่าวกิจกรรม</a>
        </div>
        <div>
            <h5>Dashboard</h5>
            <a href="/admin/dashboard">สถิติกราฟข้อมูล</a>
            <h5>เกี่ยวกับเรา</h5>
            <a href="/admin/about">ข้อมูลพื้นฐานชุมชนทุ่งเศรษฐี</a>
        </div>
    
        <div>
            <h5>บันทึกข้อมูล</h5>
            <a href="/admin/record">ข้อมูลสุขภาพ</a>
            <a href="/admin/addrecord">เพิ่มข้อมูลใหม่</a>
        </div>
    </footer>
</body>

</html>
