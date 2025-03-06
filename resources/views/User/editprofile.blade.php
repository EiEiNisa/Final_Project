@extends('layoutuser')

@section('content')
<style>
    .profile-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 40px;
        background-color: #ffffff; /* เปลี่ยนสีพื้นหลัง */
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* เพิ่มเงา */
    }

    .profile-title {
        text-align: center;
        margin-bottom: 40px;
        color: #020364;
        font-size: 28px; /* เพิ่มขนาดตัวอักษร */
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600; /* ปรับความหนาตัวอักษร */
        color: #333; /* ปรับสีตัวอักษร */
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 12px;
        font-size: 16px;
    }

    .btn-primary {
        background-color: #020364;
        border: none;
        padding: 12px 25px;
        font-size: 18px;
        border-radius: 5px;
        transition: background-color 0.3s ease; /* เพิ่มเอฟเฟกต์ transition */
    }

    .btn-primary:hover {
        background-color: #000145;
    }

    .text-danger {
        color: #dc3545;
        font-size: 14px;
    }
</style>

<div class="container">
    <div class="profile-container">
        <h2 class="profile-title"><i class="fas fa-user-edit"></i> แก้ไขโปรไฟล์</h2>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.updateprofile') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">ชื่อ</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
                    placeholder="กรอกชื่อ" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="surname" class="form-label">นามสกุล</label>
                <input type="text" class="form-control" id="surname" name="surname"
                    value="{{ old('surname', $user->surname) }}" placeholder="กรอกนามสกุล" required>
                @error('surname') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="username" class="form-label">ชื่อผู้ใช้งาน</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="{{ old('username', $user->username) }}" placeholder="กรอกชื่อผู้ใช้งาน" required>
                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}"
                    placeholder="กรอกอีเมล" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">รหัสผ่านใหม่ <span style="color:red;">(ถ้าไม่ต้องการเปลี่ยนให้เว้นว่างไว้)</span></label>
                <input type="password" name="password" class="form-control" placeholder="กรอกรหัสผ่านใหม่">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">ยืนยันรหัสผ่าน <span style="color:red;">(ถ้าไม่ต้องการเปลี่ยนให้เว้นว่างไว้)</span></label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="กรอกรหัสผ่าน">
            </div>

            <div class="form-group">
                <label for="current_password" class="form-label">กรอกรหัสผ่านเพื่อยืนยันการแก้ไข</label>
                <input type="password" class="form-control" id="current_password" name="current_password"
                    placeholder="กรอกรหัสผ่าน" required>
                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>
</div>
@endsection