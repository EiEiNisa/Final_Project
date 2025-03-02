@extends('layout')

@section('content')
<style>
/* General styling */
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
    /* Adjusted to be percentage based for responsiveness */
    max-width: 600px;
    /* Max width to prevent it from getting too wide */
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
        padding: 30px;
    }

    .box button {
        padding: 8px 15px;
        font-size: 16px;
    }

    .text {
        font-size: 12px;
    }

    .button {
        padding: 8px 40px;
        font-size: 12px;
    }
}

.spinner {
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top: 3px solid #fff;
    width: 16px;
    height: 16px;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-left: 8px;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>

@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@elseif(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="image">
    <img class="logo1" src="/logo.png" alt="Logo">
</div>

<div class="title">
    <p><strong>ลืมรหัสผ่าน</strong></p>
</div>

<div class="box">
    <form id="resetForm" action="{{ route('password.email') }}" method="POST">
        @csrf
        <label for="email" style="margin-bottom: 5px; text-align: left;">อีเมล</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="อีเมล" required>
        <br>
        <button type="submit" id="submitBtn">
            <span id="btnText">ส่งลิงค์รีเซ็ตรหัสผ่าน</span>
            <span id="btnSpinner" class="spinner" style="display: none;"></span>
        </button>
    </form>
</div>

<script>
document.getElementById("resetForm").addEventListener("submit", function() {
    let btn = document.getElementById("submitBtn");
    let btnText = document.getElementById("btnText");
    let btnSpinner = document.getElementById("btnSpinner");

    // เปลี่ยนข้อความเป็น "กำลังส่ง..."
    btnText.textContent = "กำลังส่ง...";
    btnSpinner.style.display = "inline-block";

    // ปิดการใช้งานปุ่มเพื่อป้องกันการกดซ้ำ
    btn.disabled = true;
});
</script>

@endsection