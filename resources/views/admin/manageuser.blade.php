@extends('layoutadmin')

@section('content')
<style>
.title {
    color: #020364;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 24px;
    font-weight: bold;
    border-bottom: 3px solid #020364;
    margin-bottom: 20px;
}

.box {
    background-color: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.alert-danger {
    background-color: #ffcccc;
    color: #a94442;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th,
td {
    padding: 12px 15px;
    text-align: center;
}

th {
    background-color: #020364;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

tr:nth-child(even) {
    background-color: #e9f2fb;
}

tr:hover {
    background-color: #d6e9f9;
}

.btn {
    padding: 8px 15px;
    background-color: #020364;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn:hover {
    background-color: #fff;
    transform: scale(1.05);
}

@media (max-width: 768px) {

    th,
    td {
        font-size: 14px;
        padding: 10px;
    }

    .btn {
        padding: 6px 12px;
        font-size: 14px;
    }

    .title {
        font-size: 20px;
    }
}

.custom-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    padding: 10px;
    font-size: 16px;
}

.custom-pagination a,
.custom-pagination span {
    padding: 8px 16px;
    background-color: #28a745;
    /* ปรับสีพื้นหลังเป็นสีเขียว */
    color: white;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.custom-pagination a:hover {
    background-color: #218838;
    /* สีเขียวเข้มเมื่อ hover */
}

.custom-pagination .disabled {
    background-color: #f8d7da;
    /* สีจางเมื่อปุ่ม disabled */
    color: #721c24;
    /* สีตัวอักษรที่ชัดเจน */
    cursor: not-allowed;
}

.custom-pagination .disabled:hover {
    background-color: #f8d7da;
}

.btn-cancel {
    padding: 10px 10px;
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn-cancel:hover {
    background-color: #5a6368;
}

.btn-confirm {
    padding: 10px 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn-confirm:hover {
    background-color: #218838;
}
</style>

<div class="container py-3">
    <br>
    <div class="box">
        <div class="title">
            จัดการสิทธิ์ผู้ใช้
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>อีเมล</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>บทบาท</th>
                    <th>จัดการสิทธิ์</th>
                </tr>
            </thead>

            <form action="{{ route('admin.manageuser') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="email" value="{{ request()->input('email') }}" class="form-control"
                        placeholder="ค้นหาอีเมล" aria-label="ค้นหาอีเมล">

                    <input type="text" name="name" value="{{ request()->input('name') }}" class="form-control"
                        placeholder="ค้นหาชื่อหรือนามสกุล" aria-label="ค้นหาชื่อหรือนามสกุล">

                    <button class="btn btn-primary" type="submit">ค้นหา</button>
                </div>
            </form>

            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <form action="{{ route('admin.changeRole', $user->id) }}" method="POST">
                            @csrf
                            <button type="button" class="btn" data-bs-toggle="modal"
                                data-bs-target="#confirmModal{{ $user->id }}" data-email="{{ $user->email }}"
                                data-id="{{ $user->id }}">
                                เปลี่ยนสิทธิ์
                            </button>

                            <div class="modal fade" id="confirmModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="confirmModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header text-black">
                                            <h5 class="modal-title" id="confirmModalLabel{{ $user->id }}">
                                                ยืนยันการเปลี่ยนสิทธิ์
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p>คุณต้องการเปลี่ยนสิทธิ์การใช้งานของ</p>
                                            <h5 class="text-danger" id="userEmail{{ $user->id }}"></h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn-cancel"
                                                data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" class="btn-confirm">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

            <script>
            const confirmModal = document.querySelectorAll('.modal');

            confirmModal.forEach(modal => {
                modal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget; // ปุ่มที่เปิด modal
                    const email = button.getAttribute(
                    'data-email'); // ดึงค่า email จาก data-* attribute
                    const userId = button.getAttribute('data-id'); // ดึงค่า id จาก data-* attribute

                    // แสดงอีเมลใน modal โดยใช้ userId
                    document.getElementById('userEmail' + userId).textContent = email;

                    // ตั้งค่า action ของฟอร์ม
                    const form = button.closest('form');
                    form.action = `/admin/changeRole/${userId}`;
                });
            });

            // ส่งฟอร์มเมื่อกดยืนยัน
            document.querySelectorAll('.btn-confirm').forEach(btn => {
                btn.addEventListener('click', function(event) {
                    const form = this.closest('form');
                    form.submit(); // ส่งฟอร์มเมื่อกดปุ่มยืนยัน
                });
            });
            </script>


        </table>
        <div class="custom-pagination mt-3">
            @if ($users->onFirstPage())
            <span class="disabled">ย้อนกลับ</span>
            @else
            <a href="{{ $users->previousPageUrl() }}">ย้อนกลับ</a>
            @endif

            <span>ทั้งหมด {{ $users->total() }} รายการ</span>

            @if ($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}">ถัดไป</a>
            @else
            <span class="disabled">ถัดไป</span>
            @endif
        </div>
    </div>
</div>
<br>
@endsection