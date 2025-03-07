@extends('layoutadmin')

@section('content')
<style>
    .container {
        max-width: 100%;
        margin: auto;
        padding: 0 15px;
    }
    .slide-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
    }
    .slide-item {
        text-align: center;
        width: 100%;
        max-width: 300px;
        background: white;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        margin: 10px;
    }
    .slide-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }
    .slide-controls {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
    }
    .slide-controls .btn {
        width: 100%;
    }
</style>

<div class="container py-5">
    <h2 class="text-center mb-4">จัดการสไลด์โชว์</h2>

    <!-- ปุ่มเพิ่มสไลด์ใหม่ -->
    <button class="btn btn-success mb-3" id="add-slide-btn">+ เพิ่มสไลด์ใหม่</button>

    <!-- ฟอร์มเพิ่มสไลด์ใหม่ที่ซ่อน -->
    <form id="add-slide-form" action="{{ route('slideshow.store') }}" method="POST" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input type="file" name="slide" class="form-control mb-2" accept="image/*" required>
        <button type="submit" class="btn btn-primary">อัปโหลด</button>
    </form>

    <div class="slide-container" id="slide-container">
        <!-- ดึงสไลด์ทั้งหมดจากฐานข้อมูล -->
        @foreach ($slides as $slide)
            <div class="slide-item">
                @php
                    // ตรวจสอบว่าไฟล์สไลด์มีอยู่หรือไม่
                    $slideImage = $slide->path ? asset($slide->path) : asset('images/default.png');
                @endphp

                <img src="{{ $slideImage }}?t={{ time() }}" alt="Slide {{ $slide->order }}">

                <div class="slide-controls">
                    <!-- ฟอร์มอัปเดตสไลด์ -->
                    <form action="{{ route('slideshow.update', $slide->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="slide" class="form-control mb-2" accept="image/*">
                        <button type="submit" class="btn btn-primary">อัปโหลด</button>
                    </form>

                    <!-- ฟอร์มลบสไลด์ -->
                    <form action="{{ route('slideshow.destroy', $slide->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสไลด์นี้?')">ลบ</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    // เมื่อกดปุ่ม "เพิ่มสไลด์ใหม่"
    document.getElementById('add-slide-btn').addEventListener('click', function () {
        document.getElementById('add-slide-form').style.display = 'block';  // แสดงฟอร์มการอัปโหลด
    });
</script>

@endsection
