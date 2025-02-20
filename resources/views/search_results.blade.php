@extends('layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">ผลการค้นหา: "{{ $query }}"</h2>

    <div class="mb-4">
        <a href="{{ url('/') }}" class="btn btn-secondary">ย้อนกลับไปหน้าหลัก</a>
    </div>

    @if ($articles->isEmpty())
        <p>ไม่พบบทความที่เกี่ยวข้อง</p>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            @foreach ($articles as $article)
                <div class="col">
                    <div class="card h-100 shadow-sm border-light rounded">
                        @if ($article->image)
                        <img src="{{ $article->image }}" class="card-img-top" alt="{{ $article->title }}">
                        @else
                            <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="No Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title text-truncate" style="max-width: 100%;">{{ $article->title }}</h5>
                            <p class="card-text text-truncate" style="max-width: 100%;">{{ Str::limit($article->description, 100) }}</p>
                            <a href="{{ route('guest.article', $article->id) }}" class="btn btn-primary">อ่านเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Custom CSS for responsiveness -->
<style>
    /* Responsive Design for smaller screens */
    @media (max-width: 768px) {
        .card-img-top {
            height: 200px; /* Adjust image height for smaller screens */
        }

        .card-title {
            font-size: 14px; /* Adjust font size for smaller screens */
        }

        .card-text {
            font-size: 12px; /* Adjust font size for smaller screens */
        }

        .btn-primary {
            font-size: 12px; /* Adjust button size for smaller screens */
            padding: 10px;
        }

        h2 {
            font-size: 18px; /* Adjust the title size */
        }
    }

    /* For very small screens like phones */
    @media (max-width: 480px) {
        .card {
            margin-bottom: 15px; /* Ensure cards don't touch each other */
        }

        .card-img-top {
            height: 180px; /* Further reduce image height */
        }

        .card-title {
            font-size: 13px; /* Adjust title size */
        }

        .card-text {
            font-size: 11px; /* Adjust description font size */
        }

        .btn-primary {
            font-size: 11px;
            padding: 8px;
        }

        h2 {
            font-size: 16px; /* Adjust header for small screens */
        }
    }
</style>
@endsection