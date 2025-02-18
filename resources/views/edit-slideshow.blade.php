@extends('layoutadmin')

@section('content')
<style>
    /* Styles for the page */
    .slideshow-container {
        position: relative;
        max-width: 100%;
        margin: auto;
        border-radius: 12px;
        overflow: hidden;
    }

    .slide-preview {
        width: 100%;
        height: 450px;
        object-fit: cover;
        filter: brightness(75%);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .capsule-btn {
        color: #fff;
        background-color: #020364;
        display: inline-block;
        border-radius: 50px;
        padding: 12px 28px;
        font-size: 18px;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .capsule-btn:hover {
        background-color: #0d0d61;
    }
</style>

<div class="container py-5">
    <h2>แก้ไขสไลด์</h2>

    <!-- Form to edit slideshow -->
    <form action="{{ route('admin.updateSlideshow') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @for ($i = 1; $i <= 6; $i++)
        <div class="form-group">
            <label for="slide{{ $i }}">สไลด์ {{ $i }}</label>
            <div>
                <img src="{{ asset('public/slides/slide' . $i . '.png') }}" class="slide-preview" alt="Slide {{ $i }} Preview">
            </div>
            <input type="file" class="form-control" id="slide{{ $i }}" name="slide{{ $i }}" accept="image/*">
        </div>
        @endfor

        <button type="submit" class="capsule-btn">บันทึกการแก้ไข</button>
    </form>
</div>

@endsection