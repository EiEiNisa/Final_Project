<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thung Setthi Community</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background-color: #7DA7D8;
            display: flex;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 70px; /* เริ่มต้นแสดงแค่ Icon */
            background-color: #020364;
            padding: 10px;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: width 0.3s ease; /* เพิ่มเอฟเฟกต์ขยาย */
        }

        /* เมื่อเอาเมาส์ไปชี้ที่ Sidebar ให้ขยายออก */
        .sidebar:hover {
            width: 200px; /* ขยาย Sidebar */
        }

        .sidebar .menu {
            flex-grow: 1;
        }

        .sidebar img.logo {
            display: block;
            margin: 0 auto 15px;
            width: 50px; /* ลดขนาดโลโก้ให้พอดี */
            transition: width 0.3s ease;
        }

        .sidebar:hover img.logo {
            width: 100px; /* ขยายโลโก้เมื่อ hover */
        }

        /* ปุ่มเมนู */
        .sidebar a {
            color: #ffffff;
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            margin-bottom: 8px;
            text-align: left;
            transition: background-color 0.3s ease, padding 0.3s ease;
            white-space: nowrap; /* ป้องกันตัวหนังสือขึ้นบรรทัดใหม่ */
        }

        .sidebar a i {
            font-size: 20px;
            width: 30px; /* กำหนดขนาดไอคอน */
            text-align: center;
            transition: margin-right 0.3s ease;
        }

        /* ตอน Sidebar ไม่ขยาย ให้ซ่อนข้อความ */
        .sidebar a span {
            display: none;
            transition: opacity 0.3s ease;
        }

        /* เมื่อ Hover ที่ Sidebar ให้แสดงข้อความ */
        .sidebar:hover a span {
            display: inline;
            opacity: 1;
            margin-left: 10px;
        }

        .sidebar a:hover {
            background-color: #6D91C9;
        }

        /* กล่องข้อมูลผู้ใช้ */
        .sidebar .account {
            display: flex;
            align-items: center;
            font-size: 14px;
            margin-top: 15px;
            padding: 8px;
            background-color: #343a40;
            border-radius: 6px;
            color: #FEFB18;
            white-space: nowrap;
        }

        .sidebar .account i {
            margin-right: 8px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            width: 100%;
            background-color: #dc3545;
            color: white;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: none;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            white-space: nowrap;
        }

        .logout-btn i {
            margin-right: 8px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        /* Content */
        .content {
            margin-left: 70px; /* ขยับเนื้อหาไปทางขวา */
            padding: 20px;
            flex-grow: 1;
            width: calc(100% - 70px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* ขยาย Content เมื่อ Sidebar Hover */
        .sidebar:hover ~ .content {
            margin-left: 200px;
            width: calc(100% - 200px);
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu">
            <img class="logo" src="/logo.png" alt="Logo">
            <a href="/admin/homepage"><i class="fas fa-home"></i> <span>หน้าหลัก</span></a>
            <a href="/admin/form"><i class="fas fa-plus-circle"></i> <span>เพิ่มบทความ</span></a>
            <a href="/admin/addslide"><i class="fas fa-images"></i> <span>เพิ่มสไลด์</span></a>
            <a href="/admin/about"><i class="fas fa-info-circle"></i> <span>ข้อมูลพื้นฐาน</span></a>
            <a href="/admin/addrecord"><i class="fas fa-database"></i> <span>เพิ่มข้อมูลใหม่</span></a>
            <a href="/admin/record"><i class="fas fa-folder"></i> <span>บันทึกข้อมูล</span></a> <!-- เพิ่มปุ่ม -->
            <a href="/admin/dashboard"><i class="fas fa-chart-bar"></i> <span>แดชบอร์ด</span></a>
            <a href="/admin/editprofile"><i class="fas fa-user-edit"></i> <span>แก้ไขโปรไฟล์</span></a>
            <a href="/admin/manageuser"><i class="fas fa-user-shield"></i> <span>จัดการสิทธิ์</span></a>
        </div>

        <!-- แสดงชื่อผู้ใช้งาน + ปุ่มออกจากระบบ -->
        <div>
            <div class="account">
                <i class="fas fa-user"></i> <span>{{ session('register')->username ?? 'Guest' }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> <span>ออกจากระบบ</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

</body>

</html>
