@extends('layoutadmin')

@section('content')
<style>
    .container {
        max-width: 100%;
        margin: auto;
        padding: 0 15px;
    }

    /* สไตล์สไลด์โชว์ */
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

    /* ปรับให้ปุ่มเพิ่มบทความเต็มจอในมือถือ */
    .btn-add {
        display: block;
        width: 100%;
        max-width: 200px;
        margin: 20px auto;
        background-color: #FFA500;
        color: white;
        font-weight: bold;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
    }

    .btn-add:hover {
        background-color: #FF8C00;
    }


    .article-slides {
    display: flex;
    flex-direction: column; /* ให้การ์ดเรียงกันในแนวตั้ง */
    gap: 10px; /* ระยะห่างระหว่างการ์ด */
}

/* Style for individual cards */
.card {
    display: flex; /* จัดเรียงรูปและเนื้อหาให้อยู่ในแนวนอน */
    align-items: center; /* จัดให้อยู่ตรงกลางแนวตั้ง */
    width: 100%; /* กำหนดให้การ์ดขยายเต็มพื้นที่ */
    max-width: 600px; /* ป้องกันไม่ให้การ์ดกว้างเกินไป */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เพิ่มเงา */
    border-radius: 8px; /* มุมโค้งมน */
    overflow: hidden; /* ซ่อนส่วนที่เกิน */
    background: white;
    transition: transform 0.3s ease;
}

/* Card hover effect */
.card:hover {
    transform: scale(1.02);
}

/* Image styling inside the card */
.card img {
    width: 150px; /* กำหนดขนาดของรูป */
    height: 100px;
    object-fit: cover; /* ป้องกันภาพผิดสัดส่วน */
    border-radius: 5px;
}

/* Style for card body */
.card-body {
    flex: 1; /* ให้เนื้อหาขยายได้ตามพื้นที่ที่เหลือ */
    padding: 10px 15px;
    text-align: left; /* จัดข้อความชิดซ้าย */
}

/* ปรับแต่งปุ่ม */
.btn-primary, .btn-danger {
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 5px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}


    /* ปรับแต่งปุ่ม "ย้อนกลับ" และ "ถัดไป" */
.prev, .next {
    background-color: #007bff; /* สีพื้นหลัง */
    color: white; /* สีข้อความ */
    padding: 10px 20px; /* ระยะห่างของปุ่ม */
    border-radius: 50px; /* ขอบปัดมน */
    font-size: 16px; /* ขนาดตัวอักษร */
    text-decoration: none; /* เอาเส้นขีดใต้ข้อความออก */
    display: inline-block; /* ทำให้เป็นบล็อกภายใน */
    transition: background-color 0.3s, transform 0.3s; /* เพิ่ม effect เมื่อ hover */
    cursor: pointer; /* เปลี่ยน cursor เป็น pointer เมื่อ hover */
}

.prev:hover, .next:hover {
    background-color: #0056b3; /* สีเมื่อ hover */
    transform: scale(1.1); /* ขยายขนาดปุ่มเมื่อ hover */
}

.prev {
    margin-right: 20px; /* ระยะห่างด้านขวาของปุ่มย้อนกลับ */
}

.next {
    margin-left: 20px; /* ระยะห่างด้านซ้ายของปุ่มถัดไป */
}

.prev:disabled, .next:disabled {
    background-color: #cccccc; /* สีปุ่มเมื่อไม่สามารถคลิกได้ */
    cursor: not-allowed; /* เปลี่ยน cursor เมื่อไม่สามารถคลิกได้ */
}


    /* สไตล์สำหรับหน้าจอเล็ก */
    @media (max-width: 768px) {
        .slide-item {
            width: 100%;
            max-width: 100%;
        }

        .card {
            width: 100%;
            max-width: 100%;
        }

        .btn-add {
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<div class="container py-5">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

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


<div class="container">
    <a href="form" class="btn-add">+ เพิ่มบทความ</a>
</div>

<!-- Article Slideshow -->
<div class="article-slideshow-container py-3">
    @php
        $chunkedArticles = $articles->chunk(5); // Group articles in chunks of 5
    @endphp

    @foreach($chunkedArticles as $chunk)
        <div class="article-slides">
            @foreach($chunk as $article)
                <div class="card">
                    <img src="{{ asset($article->image) }}" alt="Article Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text">{{ Str::limit($article->description, 100) }}</p>
                        <p class="text-muted">ผู้เขียน: {{ $article->author }}</p>
                        <p class="text-muted">วันที่: {{ $article->post_date }}</p>
                        <a href="{{ route('admin.article', $article->id) }}" class="btn btn-primary">อ่านเพิ่มเติม</a>
                        <form action="{{ route('article.delete', $article->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบบทความนี้?')">ลบ</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
    <!-- Next/Prev Buttons for Article Slideshow -->
    <a class="prev" onclick="plusArticleSlides(-1)">ย้อนกลับ</a>
    <a class="next" onclick="plusArticleSlides(1)">ถัดไป</a>
</div>


<!-- JavaScript for Article Slideshow -->
<script>
    let articleSlideIndex = 1;
    showArticleSlides(articleSlideIndex);

    function plusArticleSlides(n) {
        showArticleSlides(articleSlideIndex += n);
    }

    function currentArticleSlide(n) {
        showArticleSlides(articleSlideIndex = n);
    }

    function showArticleSlides(n) {
        let i;
        let slides = document.getElementsByClassName("article-slides");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) { articleSlideIndex = 1 }
        if (n < 1) { articleSlideIndex = slides.length }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[articleSlideIndex - 1].style.display = "flex";
        dots[articleSlideIndex - 1].className += " active";
    }
</script>

@endsection
