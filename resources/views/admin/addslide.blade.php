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

    <button class="btn btn-success mb-3" id="add-slide-btn">+ เพิ่มสไลด์ใหม่</button>

    <div class="slide-container" id="slide-container"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    loadSlides();  // โหลดสไลด์ที่มีอยู่จากฐานข้อมูล

    // เพิ่ม Event Listener ให้ปุ่มเพิ่มสไลด์
    document.getElementById('add-slide-btn').addEventListener('click', function () {
        let slideContainer = document.getElementById('slide-container');
        let newSlide = document.createElement('div');
        newSlide.classList.add('slide-item');

        newSlide.innerHTML = `
            <form action="{{ route('slideshow.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="slide" class="form-control mb-2" accept="image/*" required>
                <button type="submit" class="btn btn-primary">อัปโหลด</button>
            </form>
        `;

        slideContainer.appendChild(newSlide);
    });
});
    <div class="container py-5">
    <h2 class="text-center mb-4">จัดการสไลด์โชว์</h2>
    <div class="slide-container">
        @for ($i = 1; $i <= 6; $i++)
            <div class="slide-item">
                @php
                    // ตรวจสอบว่าไฟล์สไลด์มีอยู่หรือไม่
                    $slideImage = null;
                    foreach (['png', 'jpg', 'jpeg', 'webp'] as $ext) {
                        if (file_exists(public_path("images/slide$i.$ext"))) {
                            $slideImage = asset("images/slide$i.$ext");
                            break;
                        }
                    }
                    $slideImage = $slideImage ?? asset('images/default.png');
                @endphp

                <img src="{{ $slideImage }}?t={{ time() }}" alt="Slide {{ $i }}">

                <div class="slide-controls">
                    <form action="{{ route('slideshow.update', $i) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="slide" class="form-control mb-2" accept="image/*">
                        <button type="submit" class="btn btn-primary">อัปโหลด</button>
                    </form>
                    <form action="{{ route('slideshow.delete', $i) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสไลด์นี้?')">ลบ</button>
                    </form>
                </div>
            </div>
        @endfor
    </div>
</div>

</script>

@endsection
