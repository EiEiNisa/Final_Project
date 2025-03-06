@extends( 'layoutadmin')

@section('content')
<style>
    .article-container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

    .article-title {
        font-size: 36px;
        font-weight: bold;
        color: #020364;
        margin-bottom: 20px;
    }

    .article-meta {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .article-content {
        font-size: 18px;
        line-height: 1.8;
        color: #333;
        margin-bottom: 20px;
    }

    .article-image {
        width: 100%;
        max-width: 750px; /* ขนาดสูงสุดสำหรับภาพ */
        height: auto;
        border-radius: 10px;
        margin: 0 auto;
        display: block;
        margin-bottom: 20px;
    }

    .back-button {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #020364;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
    }

    .back-button:hover {
        background-color: #1a237e;
    }

    .video-container {
        position: relative;
        width: 100%;
        margin: auto;
    }

    /* ปรับขนาด iframe และ video ให้ยืดหยุ่นตามขนาดหน้าจอ */
    .video-container iframe,
    .video-container video {
        width: 100%; /* ปรับให้กว้างเต็มพื้นที่ */
        height: auto; /* รักษาสัดส่วน */
        border-radius: 10px;
    }

    /* ทำให้แน่ใจว่าวิดีโอไม่เกินขนาดที่กำหนด */
    .video-container iframe {
        max-width: 750px; /* กำหนดขนาดสูงสุด */
        height: 400px;
    }
</style>

<div class="container py-5">
    <div class="article-container">
        <h1 class="article-title">{{ $article->title }}</h1>
        <p class="article-meta">{{ $article->post_date }} | {{ $article->author }}</p>
        <img src="{{ asset($article->image) }}" class="card-img-top" alt="{{ $article->title }}">
        @if($article->video_link)
            @php
                // ตรวจสอบและแปลงลิงก์ให้อยู่ในรูปแบบ embed
                if (Str::contains($article->video_link, 'youtu.be')) {
                    // กรณีเป็น youtu.be ให้ดึงรหัสวิดีโอมาใส่ embed
                    $videoId = last(explode('/', parse_url($article->video_link, PHP_URL_PATH)));
                    $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                } elseif (Str::contains($article->video_link, 'watch?v=')) {
                    // กรณีเป็น youtube.com/watch?v= ให้แปลงเป็น embed
                    $embedUrl = str_replace("watch?v=", "embed/", $article->video_link);
                } else {
                    $embedUrl = $article->video_link; // เผื่อในอนาคตมีรูปแบบอื่น
                }
            @endphp
            <div class="video-container">
                <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
            </div>
        @endif

        @if($article->video_upload)
            <div class="video-container">
                <video class="article-video" controls>
                    <source src="{{ Storage::url($article->video_upload) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
        
        <div class="article-content">
            {!! nl2br(e($article->description)) !!}
        </div>
        <a href="javascript:history.back()" class="back-button">กลับไปหน้าหลัก</a>
    </div>
</div>
@endsection
