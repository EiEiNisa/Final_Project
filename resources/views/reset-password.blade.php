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
    /* Adjusted to be percentage-based for responsiveness */
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
    text-align: center;
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
    .title {
        font-size: 22px;
    }

    .box {
        padding: 20px;
    }

    .box input {
        font-size: 12px;
    }

    .box button {
        padding: 8px 15px;
        font-size: 12px;
    }

    .text {
        font-size: 12px;
    }
}
</style>

@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

@error('email')
<div class="alert alert-danger">
    {{ $message }}
</div>
@enderror

<div class="image">
    <img class="logo1" src="/logo.png" alt="Logo">
</div>

<div class="title">
    <p><strong>ตั้งรหัสผ่านใหม่</strong></p>
</div>

<div class="box">
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email" style="margin-bottom: 5px;">อีเมล</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', request()->email) }}"
            placeholder="กรอกอีเมล" required>
        @error('email')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="password" style="margin-bottom: 5px;">รหัสผ่านใหม่</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน" required>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่าน</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            placeholder="กรอกรหัสผ่าน" required>
        <br>
        <button type="submit">ตั้งรหัสผ่านใหม่</button>
    </form>
</div>

@endsection