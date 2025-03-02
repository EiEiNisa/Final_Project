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

        .sidebar {
            width: 220px;
            background-color: #020364;
            padding: 15px;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .menu {
            flex-grow: 1;
        }

        .sidebar img.logo {
            display: block;
            margin: 0 auto 20px;
            width: 120px;
        }

        .sidebar a {
            color: #ffffff;
            display: block;
            text-decoration: none;
            padding: 12px;
            font-size: 18px;
            border-radius: 6px;
            margin-bottom: 10px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #6D91C9;
        }

        .sidebar .account {
            text-align: center;
            font-size: 16px;
            margin-top: 20px;
            padding: 10px;
            background-color: #343a40;
            border-radius: 6px;
            color: #FEFB18;
        }

        .logout-btn {
            display: block;
            width: 100%;
            background-color: #dc3545;
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 18px;
            border-radius: 6px;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="menu">
            <img class="logo" src="/logo.png" alt="Logo">
            <a href="/admin/homepage"><i class="fas fa-home"></i> หน้าหลัก</a>
            <a href="/admin/form"><i class="fas fa-plus-circle"></i> เพิ่มบทความ</a>
            <a href="/admin/addslide"><i class="fas fa-images"></i> เพิ่มสไลด์</a>
            <a href="/admin/about"><i class="fas fa-info-circle"></i> ข้อมูลพื้นฐาน</a>
            <a href="/admin/addrecord"><i class="fas fa-database"></i> เพิ่มข้อมูลใหม่</a>
            <a href="/admin/dashboard"><i class="fas fa-chart-bar"></i> แดชบอร์ด</a>
            <a href="/admin/editprofile"><i class="fas fa-user-edit"></i> แก้ไขโปรไฟล์</a>
            <a href="/admin/manageuser"><i class="fas fa-user-shield"></i> จัดการสิทธิ์</a>
        </div>

        <!-- แสดงชื่อผู้ใช้งาน + ปุ่มออกจากระบบ -->
        <div>
            <div class="account">
                <i class="fas fa-user"></i> {{ session('register')->username ?? 'Guest' }}
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                </button>
            </form>
        </div>
    </div>

</body>

</html>
