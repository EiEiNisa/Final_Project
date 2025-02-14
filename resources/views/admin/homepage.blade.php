@extends('layoutadmin')

@section('content')
<style>
.slideshow-container {
    max-width: 820px;
    position: relative;
    margin: auto;
}

.mySlides img {
    width: 100%;
    height: 450px;
    object-fit: cover;
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

.news-header::before,
.news-header::after {
    content: "";
    position: absolute;
    top: 95.5%;
    margin-left: 145px;
    width: 75%;
    height: 3px;
    background-color: #fff;
}

.row {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 50px;
    margin-top: 20px;
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
    height: 4px;
    background: white;
}

.text {
    margin: 0 10px;
    font-size: 24px;
    color: #020364;
}
</style>

<!--- Content --->
<div class="container py-2">
    <!--- Slideshow --->
    <div class="slideshow-container py-3">
        <div class="mySlides">
            <img src="/1.png" alt="Slide 1">
        </div>
        <div class="mySlides">
            <img src="/2.png" alt="Slide 2">
        </div>
        <div class="mySlides">
            <img src="/3.png" alt="Slide 3">
        </div>
        <div class="mySlides">
            <img src="/4.png" alt="Slide 4">
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <!-- Dots -->
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
    </div>

    <!-- JavaScript -->
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
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }
    </script>

    <div class="line-container">
        <div class="text"><strong>ข่าวกิจกรรม</strong></div>
        <div class="line"></div>
    </div>

    <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="nav-link capsule" href="/admin/form"
                style="color: #fff;
                    background-color: #020364;display: flex;border-radius: 50px;display: inline-block;position: absolute; right: 30px;"> + เพิ่มบทความ </a>
        </li>
    </ul>

    <!-- Blog -->
    <div class="row">
        <div class="card" style="width: 18rem; margin-right: 30px;">
            <img src="/5.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">โครงการดูแลส่งเสริมสุขภาพ</h5>
                <p class="card-text">โครงการที่มีเป้าหมายหลักในการยกระดับคุณภาพชีวิตของประชาชนในชุมชนทุ่งเศรษฐี....</p>
                <a href="#" class="btn btn-primary">ดูเพิ่มเติม</a>
            </div>
        </div>
        <div class="card" style="width: 18rem; margin-right: 30px;">
            <img src="/6.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">วันพ่อแห่งชาติประจำปี 2567 </h5>
                <p class="card-text">โครงการวันพ่อแห่งชาติ เป็นกิจกรรมสำคัญเพื่อเฉลิมพระเกียรติพระบาทสมเด็จพระบรมชนกาธิเบศร....</p>
                <a href="#" class="btn btn-primary">ดูเพิ่มเติม</a>
            </div>
        </div>
        <div class="card" style="width: 18rem; margin-right: 30px;">
            <img src="/7.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">NCD</h5>
                <p class="card-text">รูปแบบบริการ เชิงนวัตกรรมที่มีการใช้
                    เทคโนโลยีดิจิทัล สำหรับผู้ป่วยโรคเบา
                    หวานและโรคความดันโลหิตสูง....</p>
                <a href="#" class="btn btn-primary">ดูเพิ่มเติม</a>
            </div>
        </div>
    </div>
</div>
@endsection