@extends('layout')
@section('content')
<style>
.image {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
    margin-bottom: 10px;
}

.logo1 {
    width: 200px;
}

.title {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    color: #020364;
}

.box {
    width: 90%;
    max-width: 600px;
    padding: 45px;
    border: none;
    border-radius: 10px;
    background-color: #020364;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    color: #fff;
    font-size: 15px;
}

.box button {
    display: block;
    margin: 10px auto 0;
    padding: 10px 20px;
    background-color: #7DA7D8;
    color: #020364;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 17px;
}

.box button:hover {
    background-color: #5C93D3;
}

.line-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 20px;
}

.line {
    flex: 1;
    height: 2px;
    background: white;
    margin-top: 20px;
}

.text {
    margin: 0 10px;
    font-size: 18px;
    color: #fff;
    margin-top: 20px;
}

.button-container {
    text-align: center
}

.button {
    display: inline-block;
    padding: 10px 50px;
    background-color: #020364;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 17px;
    margin-top: 10px;
    margin-bottom: 60px;
    text-decoration: none;
}

.button:hover {
    background-color: #000145;
}

@media (max-width: 768px) {
    .logo1 {
        width: 150px;
    }

    .title {
        font-size: 22px;
    }

    .box {
        padding: 30px;
    }

    .box button {
        padding: 10px 15px;
        font-size: 12px;
    }

    .line-container {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .text {
        font-size: 16px;
    }

    .button {
        padding: 10px 30px;
        font-size: 12px;
    }
}
</style>

@if (session('success'))
<div class="alert alert-success">
    {!! session('success') !!}
    <a href="{{ route('login') }}">คลิกที่นี้</a>
</div>
@endif

<div class="image">
    <img class="logo1" src="/logo.png" alt="Logo">
</div>

<div class="title">
    <p><strong>ลงทะเบียน</strong></p>
</div>

<div class="box">
    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <label for="prefix" style="margin-bottom: 5px; text-align: left;">คำนำหน้าชื่อ</label>
        <select class="form-control" id="prefix" name="prefix">
            <option value="นาย">นาย</option>
            <option value="นาง">นาง</option>
            <option value="นางสาว">นางสาว</option>
        </select>
        <br>
        <label for="name" style="margin-bottom: 5px; text-align: left;">ชื่อ</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="กรอกชื่อ"
            required>
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="surname" style="margin-bottom: 5px; text-align: left;">นามสกุล</label>
        <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}"
            placeholder="กรอกนามสกุล" required>
        @error('surname')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="username" style="margin-bottom: 5px;">ชื่อผู้ใช้งาน</label>
        <br>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}"
            placeholder="กรอกชื่อผู้ใช้งาน" required>
        @error('username')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="email" style="margin-bottom: 5px; text-align: left;">อีเมล</label>
        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
            placeholder="กรอกอีเมล" required>
        @error('email')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <br>
        <input type="hidden" name="role" value="user">
        <label for="password" style="margin-bottom: 5px;">รหัสผ่าน</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="กรอกรหัสผ่าน" required>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่าน</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            placeholder="กรอกรหัสผ่าน" required>
        <br>
        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITEKEY') }}"></div>
        @error('g-recaptcha-response')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <br>
        <button type="submit">ลงทะเบียน</button>
    </form>
</div>

<div class="line-container">
    <div class="line"></div>
    <div class="text">มีบัญชีอยู่แล้ว ?</div>
    <div class="line"></div>
</div>

<div class="button-container">
    <a href="/login" class="button">เข้าสู่ระบบ</a>
</div>

@endsection