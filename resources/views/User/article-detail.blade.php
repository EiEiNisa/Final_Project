@extends('layoutuser')

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
        max-width: 750px; /* กำหนดขนาดสูงสุดให้พอดี */
        height: auto;
        border-radius: 10px;
        margin: 0 auto; /* จัดตำแหน่งให้อยู่กลาง */
        display: block; /* ให้รูปภาพเป็น block เพื่อจัดตำแหน่ง */
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
</style>

<div class="container py-5">
    <div class="article-container">
        <h1 class="article-title">{{ $article->title }}</h1>
        <p class="article-meta">{{ $article->post_date }} | {{ $article->author }}</p>
        <img class="article-image" src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
        <div class="article-content">
            {!! nl2br(e($article->description)) !!}
        </div>
        <a href="{{ route('/user/homepage') }}" class="back-button">กลับไปหน้าหลัก</a>
    </div>
</div>