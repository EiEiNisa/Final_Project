@extends('layoutadmin')

@section('content')

<div class="container mt-4 p-4 rounded shadow-lg" style="margin-bottom:50px; max-width: 800px; background-color: #f0f8ff; border: 2px solid #5a9fcf; position: relative; overflow: hidden;">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="/admin/homepage" class="btn btn-light text-primary mb-4" style="border: 2px solid #5a9fcf; color: #005f99;">&larr; กลับสู่หน้าหลัก</a>
    <h2 class="text-center mb-4" style="color: #005f99; font-weight: bold; position: relative;">เพิ่มบทความใหม่</h2>
    
    <div class="text-center mb-3">
        <img src="/images/doctor-cartoon.png" alt="การ์ตูนแพทย์" style="width: 100px; animation: bounce 1.5s infinite;">
    </div>

    <form action="{{ route('admin.form.submit') }}" method="POST" enctype="multipart/form-data" class="p-3 border rounded bg-white shadow-sm" style="border-color: #5a9fcf;">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label fw-bold" style="color: #005f99;">ชื่อเรื่อง</label>
            <input type="text" class="form-control" id="title" name="title" required style="border: 2px solid #5a9fcf; transition: 0.3s;" onfocus="this.style.backgroundColor='#e0f2ff'" onblur="this.style.backgroundColor='white'">
        </div>

        <div class="mb-3">
            <label for="images" class="form-label fw-bold" style="color: #005f99;">อัพโหลดรูปภาพ (อัปโหลดได้หลายไฟล์)</label>
            <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required style="border: 2px solid #5a9fcf;">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-bold" style="color: #005f99;">คำอธิบายในโพสต์</label>
            <textarea class="form-control" id="description" name="description" rows="4" required style="border: 2px solid #5a9fcf; transition: 0.3s;" onfocus="this.style.backgroundColor='#e0f2ff'" onblur="this.style.backgroundColor='white'"></textarea>
        </div>

        <div class="mb-3">
            <label for="post_date" class="form-label fw-bold" style="color: #005f99;">วัน/เดือน/ปี ที่โพสต์</label>
            <input type="date" class="form-control" id="post_date" name="post_date" required style="border: 2px solid #5a9fcf;">
        </div>

        <div class="mb-3">
            <label for="video_link" class="form-label fw-bold" style="color: #005f99;">ลิงก์วิดีโอ (ถ้ามี)</label>
            <input type="url" class="form-control" id="video_link" name="video_link" placeholder="https://youtube.com/..." style="border: 2px solid #5a9fcf;">
        </div>

        <div class="mb-3">
            <label for="video_upload" class="form-label fw-bold" style="color: #005f99;">อัปโหลดไฟล์วิดีโอ (ถ้ามี)</label>
            <input type="file" class="form-control" id="video_upload" name="video_upload" accept="video/*" style="border: 2px solid #5a9fcf;">
        </div>

        <div class="mb-3">
            <label for="author" class="form-label fw-bold" style="color: #005f99;">ชื่อผู้โพสต์</label>
            <input type="text" class="form-control" id="author" name="author" required style="border: 2px solid #5a9fcf;">
        </div>

        <button type="submit" class="btn w-100 fw-bold" style="background-color: #5a9fcf; color: white; border: 2px solid #005f99; transition: 0.3s;" onmouseover="this.style.backgroundColor='#005f99'" onmouseout="this.style.backgroundColor='#5a9fcf'">เสร็จสิ้น</button>
    </form>
</div>

<style>
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
</style>

@endsection
