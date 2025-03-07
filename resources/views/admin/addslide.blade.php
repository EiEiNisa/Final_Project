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
// ตรวจสอบเมื่อโหลดหน้าจอแล้ว
document.addEventListener('DOMContentLoaded', function () {
    loadSlides();  // โหลดสไลด์ที่มีอยู่จาก API

    // เพิ่ม Event Listener ให้ปุ่มเพิ่มสไลด์
    document.getElementById('add-slide-btn').addEventListener('click', function () {
        let slideContainer = document.getElementById('slide-container');
        let newSlide = document.createElement('div');
        newSlide.classList.add('slide-item');
        
        // เพิ่มฟอร์มการอัปโหลดสไลด์ใหม่
        newSlide.innerHTML = `
            <form id="add-slide-form" action="{{ route('slideshow.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="slide" class="form-control mb-2" accept="image/*" required>
                <button type="submit" class="btn btn-primary">อัปโหลด</button>
            </form>
        `;
        slideContainer.appendChild(newSlide);

        // ใช้ event listener ในการส่งฟอร์มผ่าน fetch API
        newSlide.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();  // ป้องกันการ submit แบบปกติ
            
            const formData = new FormData(this);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // ส่งคำขอ POST ผ่าน fetch API พร้อม CSRF token
            fetch("{{ route('slideshow.store') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token,
                }
            })
            .then(response => response.json())
            .then(data => {
                alert('เพิ่มสไลด์สำเร็จ');
                loadSlides();  // รีเฟรชสไลด์หลังจากอัปโหลด
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

// ฟังก์ชันโหลดสไลด์จาก API
function loadSlides() {
    fetch('/api/slides')
        .then(response => response.json())
        .then(slides => {
            let slideContainer = document.getElementById('slide-container');
            slideContainer.innerHTML = '';  // เคลียร์เนื้อหาก่อน

            slides.forEach(slide => {
                let slideItem = document.createElement('div');
                slideItem.classList.add('slide-item');
                
                // ใช้ฟังก์ชัน escape() เพื่อป้องกัน XSS
                slideItem.innerHTML = `
                    <img src="${encodeURIComponent(slide.path)}" alt="Slide ${slide.order}">
                    <div class="slide-controls">
                        <form action="/admin/slideshow/update/${slide.id}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="slide" class="form-control mb-2" accept="image/*">
                            <button type="submit" class="btn btn-primary">อัปโหลด</button>
                        </form>
                        <button class="btn btn-danger" onclick="deleteSlide(${slide.id})">ลบ</button>
                    </div>
                `;
                slideContainer.appendChild(slideItem);
            });
        })
        .catch(error => console.error('Error:', error));
}

// ฟังก์ชันลบสไลด์
function deleteSlide(slideId) {
    if (confirm('คุณแน่ใจหรือไม่ที่จะลบสไลด์นี้?')) {
        fetch(`/admin/slideshow/delete/${slideId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadSlides();  // รีเฟรชหลังจากลบสไลด์
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>

@endsection
