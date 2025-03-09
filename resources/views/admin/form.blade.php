@extends('layoutadmin')

@section('content')

<div class="container mt-4" style="margin-bottom:50px; max-width: 800px;">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="/admin/homepage" class="btn btn-secondary mb-4">&larr; กลับสู่หน้าหลัก</a>
    <h2 class="text-center mb-4">เพิ่มบทความใหม่</h2>

    <form action="{{ route('admin.form.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">ชื่อเรื่อง</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">อัพโหลดรูปภาพ (อัปโหลดได้หลายไฟล์)</label>
            <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">คำอธิบายในโพสต์</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="post_date" class="form-label">วัน/เดือน/ปี ที่โพสต์</label>
            <input type="date" class="form-control" id="post_date" name="post_date" required>
        </div>

        <div class="mb-3">
            <label for="video_link" class="form-label">ลิงก์วิดีโอ (ถ้ามี)</label>
            <input type="url" class="form-control" id="video_link" name="video_link" placeholder="https://youtube.com/...">
        </div>

        <div class="mb-3">
            <label for="video_upload" class="form-label">อัปโหลดไฟล์วิดีโอ (ถ้ามี)</label>
            <input type="file" class="form-control" id="video_upload" name="video_upload" accept="video/*">
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">ชื่อผู้โพสต์</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">เสร็จสิ้น</button>
    </form>
</div>

@endsection
