@extends('')

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
    width: 600px;
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
</style>

<div class="container">
    <br>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <!--<div class="image">
    <img class="logo1" src="/logo.png" alt="Logo">
</div>-->
    <br>
    <div class="title">
        <p><strong>แก้ไขโปรไฟล์</storng>
        </p>
    </div>

    <div class="box">
        <form action="{{ route('user.updateprofile') }}" method="POST">
            @csrf
            <label for="name" style="margin-bottom: 5px; text-align: left;">ชื่อ</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
                placeholder="กรอกชื่อ" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            <br>
            <label for="surname" style="margin-bottom: 5px; text-align: left;">นามสกุล</label>
            <input type="text" class="form-control" id="surname" name="surname"
                value="{{ old('surname', $user->surname) }}" placeholder="กรอกนามสกุล" required>
            @error('surname') <small class="text-danger">{{ $message }}</small> @enderror
            <br>
            <label for="username" style="margin-bottom: 5px;">ชื่อผู้ใช้งาน</label>
            <br>
            <input type="text" class="form-control" id="username" name="username"
                value="{{ old('username', $user->username) }}" placeholder="กรอกชื่อผู้ใช้งาน" required>
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            <br>
            <label for="email" style="margin-bottom: 5px; text-align: left;">อีเมล</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}"
                placeholder="กรอกอีเมล" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            <br>
            <label class="form-label">รหัสผ่านใหม่ <span style="color:red;">(ถ้าไม่ต้องการเปลี่ยนให้เว้นว่างไว้)</sapn></label>
            <input type="password" name="password" class="form-control" placeholder="กรอกรหัสผ่านใหม่">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            <br>
            <label class="form-label">ยืนยันรหัสผ่าน <span style="color:red;">(ถ้าไม่ต้องการเปลี่ยนให้เว้นว่างไว้)</sapn></label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="กรอกรหัสผ่าน">
            <br>
            <label for="current_password" style="margin-bottom: 5px;">กรอกรหัสผ่านเพื่อยืนยันการแก้ไข</label>
            <input type="password" class="form-control" id="current_password" name="current_password"
                placeholder="กรอกรหัสผ่าน" required>
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
            <br>
            <button type="submit">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>
</div>
@endsection