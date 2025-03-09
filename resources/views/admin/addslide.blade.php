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
                    @method('DELETE') <!-- ใช้เพื่อบอกว่าเป็นการส่งคำขอ DELETE -->
                    <button type="submit" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสไลด์นี้?')">ลบ</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ฟอร์มเพิ่มสไลด์ -->
<button class="btn btn-success" id="add-slide-btn">+ เพิ่มสไลด์ใหม่</button>
<div id="slide-container"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("add-slide-btn").addEventListener("click", function () {
        let slideContainer = document.getElementById("slide-container");
        let newSlide = document.createElement("div");
        newSlide.classList.add("slide-item");

        // สร้างฟอร์มใหม่แบบไม่ใช้ innerHTML
        let form = document.createElement("form");
        form.action = "{{ route('slideshow.store') }}";
        form.method = "POST";
        form.enctype = "multipart/form-data";

        // สร้าง input type file
        let inputFile = document.createElement("input");
        inputFile.type = "file";
        inputFile.name = "slide";
        inputFile.classList.add("form-control", "mb-2");
        inputFile.accept = "image/*";
        inputFile.required = true;

        // สร้างปุ่ม Submit
        let submitButton = document.createElement("button");
        submitButton.type = "submit";
        submitButton.classList.add("btn", "btn-primary");
        submitButton.innerText = "อัปโหลด";

        // เพิ่ม input และปุ่มลงในฟอร์ม
        form.appendChild(inputFile);
        form.appendChild(submitButton);

        // เพิ่มฟอร์มเข้าไปใน newSlide
        newSlide.appendChild(form);

        // เพิ่ม newSlide ลงใน slideContainer
        slideContainer.appendChild(newSlide);
    });
});
</script>


@endsection
