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
        width: 60px; /* ปรับให้แคบลง */
        background-color: #020364; /* เปลี่ยนเป็นสีฟ้าสว่าง */
        padding: 10px;
        position: fixed;
        height: 100vh;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        transition: width 0.3s ease;
        overflow: hidden;
        align-items: center;
    }

    .sidebar:hover {
        width: 180px; /* ขยาย Sidebar */
        background-color:#020364; /* เปลี่ยนสีเมื่อ Hover */
    }

    .sidebar .menu {
        flex-grow: 1;
        overflow-y: auto;
        scrollbar-width: none;
    }

    .sidebar .menu::-webkit-scrollbar {
        display: none;
    }

    /* โลโก้ให้อยู่ตรงกลาง */
    .sidebar .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
    }

    .sidebar img.logo {
        width: 45px; /* ลดขนาดโลโก้ */
        transition: width 0.3s ease;
    }

    .sidebar:hover img.logo {
        width: 85px; /* ขยายโลโก้ */
    }

    /* ปุ่มเมนู */
    .sidebar a {
        color: #ffffff;
        display: flex;
        align-items: center;
        text-decoration: none;
        padding: 8px;
        font-size: 14px; /* ลดขนาดฟอนต์ */
        border-radius: 5px;
        margin-bottom: 5px;
        text-align: left;
        transition: background-color 0.3s ease, padding 0.3s ease;
        white-space: nowrap;
    }

    .sidebar a i {
        font-size: 18px; /* ลดขนาดไอคอน */
        width: 24px;
        text-align: center;
        transition: margin-right 0.3s ease;
    }

    .sidebar a span {
        display: none;
        transition: opacity 0.3s ease;
    }

    .sidebar:hover a span {
        display: inline;
        opacity: 1;
        margin-left: 8px;
    }

    .sidebar a:hover {
        background-color: #2E78C2;
    }

    /* กล่องข้อมูลผู้ใช้และปุ่มออกจากระบบ */
    .sidebar .account,
    .logout-btn {
        display: flex;
        align-items: center;
        font-size: 12px; /* ลดขนาดตัวอักษร */
        padding: 8px;
        border-radius: 5px;
        text-align: center;
        justify-content: center;
        white-space: nowrap;
    }

    .sidebar .account {
        background-color: #3B5998;
        color: #FFD700; /* สีทองอ่อน */
    }

    .sidebar .account i,
    .logout-btn i {
        font-size: 16px; /* ลดขนาดไอคอน */
        margin-right: 0;
    }

    .sidebar .account span,
    .logout-btn span {
        display: none;
        transition: opacity 0.3s ease;
    }

    .sidebar:hover .account span,
    .sidebar:hover .logout-btn span {
        display: inline;
        opacity: 1;
        margin-left: 8px;
    }

    .logout-btn {
        background-color: #D9534F;
        color: white;
        cursor: pointer;
        border: none;
        margin-top: 10px;
    }

    .logout-btn:hover {
        background-color: #C9302C;
    }

    /* Content */
    .content {
        margin-left: 60px;
        padding: 20px;
        flex-grow: 1;
        width: calc(100% - 60px);
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    .sidebar:hover ~ .content {
        margin-left: 180px;
        width: calc(100% - 180px);
    }

    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu">
            <img class="logo" src="/logo.png" alt="Logo">
            <br>
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
