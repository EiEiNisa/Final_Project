<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="Permissions-Policy" content="accelerometer=(self), gyroscope=(self), device-orientation=(self)">
<title>Thung Setthi Community</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>
body {
    background-color: #7DA7D8;
    font-family: 'Arial', sans-serif;
    font-size: 15px;
}

.logo {
    padding-right: 10px;
    width: 60px;
}

.navbar {
    font-size: 15px;
    background-color: #020364;
    padding: 10px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-toggler {
    border-color: #ffffff;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255,255,255,0.55)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}

.nav-link {
    white-space: nowrap;
}

.navbar-nav {
    padding-top: 15px;
    align-items: center;
}

footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    padding: 50px;
    background-color: #020364;
    color: #fff;
}

.footer-content {
    display: flex;
    flex-direction: column;

}

.footer-content h4,
.footer-content p,
.footer-content a {
    margin-bottom: 10px;
}

.footer-iframe {
    display: flex;
    justify-content: flex-end;
    flex: 1;
}

.no-underline-link {
    text-decoration: none;
    color: #fff;
}

.form-inline {
    width: 100%;
    margin-bottom: 10px;
}

.form-inline {
    width: 100%;
    margin-right: 10px;
}

@media (max-width: 576px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar-brand,
    .nav-link {
        margin-bottom: 10px;
    }

    .nav-item {
        margin-bottom: 10px;
    }

    footer {
        flex-direction: column;
        align-items: center;
    }

    .footer-content {
        padding-top: 10px;
        margin-right: 0;
        margin-bottom: 20px;
    }

    .footer-iframe {
        width: 100%;
        justify-content: center;
        align-items: center;
    }
}
</style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <img class="logo" src="/logo.png" alt="Logo">
            <a class="navbar-brand" href="/"
                style="color: #fff; font-size:15px; align-items: center;">ชุมชนทุ่งเศรษฐี</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <form class="d-flex form-inline">
                        <input class="form-control" type="search" placeholder="ค้นหา" aria-label="Search" name="query"
                            required>
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
        <div class="footer-content">
            <h4>ที่อยู่</h4>
            <p>227/521 หมู่ 6 ถนนประชาสโมสร ตำบลในเมือง<br>อำเภอเมือง ขอนแก่น จังหวัดขอนแก่น 40000</p>
            <hr>
            <h4>ช่องทางการติดต่อ</h4>
            <a href="https://www.facebook.com/profile.php?id=100089961199904" style="color: #fff;">Facebook : จิตอาสา
                ชุมชน ทุ่งเศรษฐี</a>
            <a href="mailto:vlt227.521@gmail.com" style="color: #fff;">Email : vlt227.521@gmail.com</a>
        </div>
        <div class="footer-iframe">
            <iframe
                src="https://www.google.com/maps/embed?pb=!4v1732121802730!6m8!1m7!1sXVIYDk14khUq5Us2LVmU-A!2m2!1d16.43429993272521!2d102.8685188069868!3f105.96647009275887!4f11.296777919927024!5f0.7820865974627469"
                width="80%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>