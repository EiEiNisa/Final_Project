@extends('layoutuser')

@section('content')
<style>
    /* Slideshow container */
    .slideshow-container {
        max-width: 700px;
        position: relative;
        margin: auto;
        border-radius: 15px;
        overflow: hidden;
    }

    .mySlides img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
    }

    .mySlides {
        display: none;
    }

    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        margin-top: -22px;
        padding: 16px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        background-color: rgba(242, 246, 227, 0.5);
    }

    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .dot {
        cursor: pointer;
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
    }

    .active,
    .dot:hover {
        background-color: #717171;
    }

    /* Article Slideshow Styles */
    .article-slideshow-container {
        max-width: 700px;
        position: relative;
        margin: auto;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
        margin-top: 50px;
    }

    .article-slides {
        display: none;
        display: flex;
        justify-content: space-between;
    }

    .card {
        width: 32%;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 15px;
        background-color: #f9f9f9;
    }

    .card-title {
        font-size: 15px;
        font-weight: bold;
        color: #333;
    }

    .card-text {
        color: #555;
        font-size: 13px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .btn-primary {
        background-color: #2c3b77;
        color: white;
        border: none;
        padding: 12px;
        font-size: 13px;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0099cc;
    }

    /* Responsive Styles */
    @media (max-width: 768px) { /* For tablets and smaller devices */
        .slideshow-container {
            max-width: 100%;
        }

        .mySlides img {
            height: 250px; /* Reduced size on mobile */
        }

        .article-slideshow-container {
            max-width: 100%;
        }

        .card {
            width: 48%;
            margin-bottom: 15px;
        }

        .card img {
            height: 180px; /* Adjust image size */
        }

        .card-title {
            font-size: 14px;
        }

        .card-text {
            font-size: 12px;
        }

        .btn-primary {
            font-size: 12px;
            padding: 10px;
        }

        .prev, .next {
            font-size: 16px;
            padding: 12px;
        }
    }

    @media (max-width: 480px) { /* For small phones */
        .slideshow-container {
            max-width: 100%;
        }

        .mySlides img {
            height: 200px; /* Further reduced height for small screens */
        }

        .article-slideshow-container {
            max-width: 100%;
        }

        .card {
            width: 100%;
            margin-bottom: 15px;
        }

        .card img {
            height: 150px;
        }

        .card-title {
            font-size: 13px;
        }

        .card-text {
            font-size: 11px;
        }

        .btn-primary {
            font-size: 11px;
            padding: 8px;
        }

        .prev, .next {
            font-size: 14px;
            padding: 10px;
        }
    }
</style>

<div class="container py-2">
    <!-- Image Slideshow -->
    <div class="slideshow-container py-3">
        @for ($i = 1; $i <= 6; $i++)
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
            
            <div class="mySlides">
                <img src="{{ $slideImage }}?t={{ time() }}" alt="Slide {{ $i }}">
            </div>
        @endfor

        <!-- Next/Prev Buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>


<!-- Dots -->
<div style="text-align:center">
    @for ($i = 1; $i <= 6; $i++) <span class="dot" onclick="currentSlide({{ $i }})"></span>
        @endfor
</div>
</div>




<!-- JavaScript for Image Slideshow -->
<script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }
    setInterval(function() {
        plusSlides(1);
    }, 3000); // Change slide every 3 seconds
</script>

    <!-- Article Slideshow -->
    <div class="article-slideshow-container py-3">
        @php
            $chunkedArticles = $articles->chunk(3); // Group articles in chunks of 3
        @endphp

        @foreach($chunkedArticles as $chunk)
            <div class="article-slides">
                @foreach($chunk as $article)
                    <div class="card">
                    <img src="{{ asset($article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                    <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->description, 100) }}</p>
                            <p class="text-muted">ผู้เขียน: {{ $article->author }}</p>
                            <p class="text-muted">วันที่: {{ $article->post_date }}</p>
                            <a href="{{ route('guest.article', $article->id) }}" class="btn btn-primary">อ่านเพิ่มเติม</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    
        <!-- Next/Prev Buttons for Article Slideshow -->
        <a class="prev" onclick="plusArticleSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusArticleSlides(1)">&#10095;</a>
    </div>

    <!-- Dots for Article Slideshow -->
    <div style="text-align:center">
        @foreach($chunkedArticles as $index => $chunk)
            <span class="dot" onclick="currentArticleSlide({{ $index + 1 }})"></span>
        @endforeach
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

</div>
@endsection