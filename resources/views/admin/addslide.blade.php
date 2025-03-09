@extends('layoutadmin')
@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 0 15px;
    }

    h2 {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin-bottom: 30px;
        text-align: center;
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
        background: #ffffff;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
        margin: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .slide-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 12px 30px rgba(0, 0, 0, 0.15);
    }

    .slide-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .slide-controls {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .slide-controls .btn {
        width: 100%;
    }

    .slide-controls button {
        transition: background-color 0.3s ease;
    }

    .slide-controls .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .slide-controls .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .slide-controls .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .slide-controls .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    #add-slide-btn {
        display: block;
        width: 200px;
        margin: 30px auto;
        padding: 10px 20px;
        font-size: 16px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #add-slide-btn:hover {
        background-color: #218838;
    }

    /* กรอบฟอร์มสำหรับการอัปโหลด */
    .slide-item form {
        margin-top: 20px;
    }

    .slide-item input[type="file"] {
        margin-bottom: 15px;
    }
</style>

<div class="container py-5">
    <h2>จัดการสไลด์โชว์</h2>
    <div class="slide-container" id="slide-container">
        @foreach ($slides as $slide)
            <div class="slide-item">
                <img src="{{ asset($slide->path) }}" alt="Slide {{ $slide->order }}">
                <div class="slide-controls">
                    <form action="{{ route('slideshow.update', $slide->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" name="slide" class="form-control mb-2" accept="image/*">
                        <button type="submit" class="btn btn-primary">อัปโหลด</button>
                    </form>
                    <form action="{{ route('slideshow.delete', $slide->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสไลด์นี้?')">ลบ</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ปุ่มเพิ่มสไลด์ -->
    <button class="btn btn-success" id="add-slide-btn">+ เพิ่มสไลด์ใหม่</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("add-slide-btn").addEventListener("click", function () {
            let slideContainer = document.getElementById("slide-container");
            let newSlide = document.createElement("div");
            newSlide.classList.add("slide-item");

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
</script>

@endsection
