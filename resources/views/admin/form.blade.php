@extends('layoutadmin')

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container mt-2" style="margin-bottom:50px;">
    <!-- Button to go back to the main page -->
    <a href="/admin/homepage" class="btn btn-secondary mb-4">
        < กลับสู่หน้าหลัก </a>
            <h2 class="text-center mb-4">เพิ่มบทความใหม่</h2>
            <!-- Form for posting -->

            <form action="{{ route('admin.form.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">ชื่อเรื่อง</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">อัพโหลดรูปภาพ</label>
                    <input type="file" class="form-control" id="image" name="images" accept="image/*" required>
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
                    <label for="author" class="form-label">ชื่อผู้โพสต์</label>
                    <input type="text" class="form-control" id="author" name="author" required>
                </div>

                <button type="submit" class="btn btn-primary">เสร็จสิ้น</button>
            </form>

</div>

@endsection