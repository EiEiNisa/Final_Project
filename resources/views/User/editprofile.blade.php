@extends('layoutuser')

@section('content')
<style>
.profile-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.profile-title {
    text-align: center;
    margin-bottom: 30px;
    color: #020364;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-weight: bold;
}

.btn-primary {
    background-color: #020364;
    border-color: #020364;
}

.btn-primary:hover {
    background-color: #000145;
    border-color: #000145;
}

.text-danger {
    color: #dc3545;
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
                <label for="name" style="margin-bottom: 5px; text-align: left;">ชื่อ</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
                    placeholder="กรอกชื่อ" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <br>
            <div class="form-group">
                <label for="surname" style="margin-bottom: 5px; text-align: left;">นามสกุล</label>
                <input type="text" class="form-control" id="surname" name="surname"
                    value="{{ old('surname', $user->surname) }}" placeholder="กรอกนามสกุล" required>
                @error('surname') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <br>
            <div class="form-group">
                <label for="username" style="margin-bottom: 5px;">ชื่อผู้ใช้งาน</label>
                <br>
                <input type="text" class="form-control" id="username" name="username"
                    value="{{ old('username', $user->username) }}" placeholder="กรอกชื่อผู้ใช้งาน" required>
                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <br>
            <div class="form-group">
                <label for="email" style="margin-bottom: 5px; text-align: left;">อีเมล</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}"
                    placeholder="กรอกอีเมล" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <br>
            <div class="form-group">
                <label class="form-label">รหัสผ่านใหม่ <span style="color:red;">(ถ้าไม่ต้องการเปลี่ยนให้เว้นว่างไว้)
                        </sapn></label>
                <input type="password" name="password" class="form-control" placeholder="กรอกรหัสผ่านใหม่">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <br>
            <div class="form-group">
                <label class="form-label">ยืนยันรหัสผ่าน <span style="color:red;">(ถ้าไม่ต้องการเปลี่ยนให้เว้นว่างไว้)
                        </sapn></label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="กรอกรหัสผ่าน">
            </div>
            <br>
            <div class="form-group">
                <label for="current_password" style="margin-bottom: 5px;">กรอกรหัสผ่านเพื่อยืนยันการแก้ไข</label>
                <input type="password" class="form-control" id="current_password" name="current_password"
                    placeholder="กรอกรหัสผ่าน" required>
                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <br>
            <button type="submit">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>
</div>
@endsection