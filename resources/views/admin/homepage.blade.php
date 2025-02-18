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

    /* บล็อกบทความ */
    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        width: 100%;
        max-width: 300px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
        margin: 10px;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .card-body {
        padding: 15px;
        text-align: center;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007BFF;
        color: white;
        padding: 10px;
        border-radius: 6px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
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
    <h2 class="text-center mb-4">จัดการสไลด์โชว์</h2>
    <div class="slide-container">
        @for ($i = 1; $i <= 6; $i++)
            <div class="slide-item">
            <img src="{{ asset('public/storge/slides/slide' . $i . '.png') }}" alt="Slide {{$i}}">
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

<div class="container">
    <h2 class="text-center mb-4">บทความทั้งหมด</h2>
    <div class="row">
        @foreach($articles as $article)
        <div class="card">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <p class="text-muted">โดย {{ $article->author }} - {{ $article->post_date }}</p>
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
</div>
@endsection