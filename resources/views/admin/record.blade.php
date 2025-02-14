@extends('layoutadmin')

@section('content')
<style>
.title {
    color: #020364;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    /* เพื่อให้ปุ่มแตกแถวในหน้าจอเล็ก */
}

.btn-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    /* เพื่อให้ปุ่มแตกแถวในหน้าจอเล็ก */
}

.table {
    margin-top: 10px;
    margin-bottom: 10px;
    width: 100%;
}

.table th {
    background-color: #020364;
    color: #fff;
    text-align: center;
}

.table td {
    background-color: #7DA7D8;
    color: #fff;
    word-wrap: break-word;
    max-width: 200px;
    text-align: center;
}

.table td:nth-child(2),
.table td:nth-child(7) {
    max-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.rectangle-box {
    max-width: 100%;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-group-horizontal {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: nowrap;
    overflow-x: auto;
}

.form-group {
    flex: 1;
    min-width: 200px;
}

label {
    font-size: 14px;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
    /* เพิ่มช่องว่างด้านล่าง */
}

.input-group {
    display: flex;
    align-items: center;
    position: relative;
}

.form-control {
    border-radius: 30px;
    padding: 12px 20px;
    border: 1px solid #ddd;
    box-sizing: border-box;
    width: 100%;
}

.input-group-text {
    background-color: #e7e7e7;
    border: none;
    border-radius: 50%;
    padding: 10px;
    margin-left: -30px;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
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
    color: white;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.custom-pagination a:hover {
    background-color: #218838;
}

.custom-pagination .disabled {
    background-color: #f8d7da;
    color: #721c24;
    cursor: not-allowed;
}

.custom-pagination .disabled:hover {
    background-color: #f8d7da;
}

.modal-header {
    padding: 15px;
}

.modal-title {
    margin: 0;
}

.close-btn {
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.2rem;
    transition: background-color 0.3s, transform 0.2s;
}

.close-btn:hover {
    background-color: #f8d7da;
    color: #721c24;
    transform: scale(1.1);
    cursor: pointer;

}

@media (max-width: 576px) {
    .title {
        font-size: 12px;
        flex-direction: column;
        align-items: center;
    }

    .title h4 {
        margin-bottom: 10px;
    }

    .btn-container {
        font-size: 12px;
        flex-direction: row;
        justify-content: center;
    }

    .btn-container .btn {
        font-size: 12px;
        width: 30%;
        margin-bottom: 10px;
    }

    .form-group-horizontal {
        font-size: 12px;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .form-group,
    .btn-primary {
        font-size: 12px;
        flex: 0 0 auto;
    }

    .form-group label {
        font-size: 12px;
    }

    .input-group .form-control {
        padding: 8px 15px;
    }

    .input-group-text {
        padding: 8px;
    }

    .btn-primary {
        padding: 8px 15px;
        font-size: 12px;
    }

    .table,
    .table td {
        font-size: 12px;
    }

    .table th,
    .table td {
        padding: 6px 8px;
    }

    .table td:nth-child(2),
    .table td:nth-child(7) {
        max-width: 120px;
    }

    .table td:nth-child(1),
    .table td:nth-child(3),
    .table td:nth-child(4),
    .table td:nth-child(5),
    .table td:nth-child(6),
    .table td:nth-child(8),
    .table td:nth-child(9) {
        word-wrap: break-word;
        white-space: normal;

    }

    .custom-pagination {
        font-size: 14px;
        padding: 5px;
    }

    .custom-pagination a,
    .custom-pagination span {
        padding: 6px 12px;
    }

    .modal-dialog {
        max-width: 90%;
        margin: 1.75rem auto;
    }

    .modal-content {
        padding: 10px;
    }

    .modal-header {
        padding: 10px;
    }

    .modal-title {
        font-size: 16px;
    }

    .close-btn {
        width: 30px;
        height: 30px;
        font-size: 1rem;
    }

    .modal-body .form-label {
        font-size: 14px;
    }

    .modal-body .form-control {
        padding: 8px;
        font-size: 14px;
    }

    .modal-body .btn-primary {
        padding: 10px;
        font-size: 14px;
    }

}
</style>

<div class="container py-2">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="title">
        <h4><strong>บันทึกข้อมูล</strong></h4>
        <div class="btn-container">
            <!-- Import File -->
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                นำเข้าข้อมูล
            </button>
            <!-- Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between align-items-center">
                            <h5 class="modal-title" id="importModalLabel">นำเข้าข้อมูล</h5>
                            <button type="button" class="btn btn-light rounded-circle shadow-sm close-btn"
                                data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="excelFile" class="form-label fw-bold">เลือกไฟล์ Excel
                                        ที่ต้องการนำเข้า</label>
                                    <input type="file" class="form-control" id="excelFile" name="file"
                                        accept=".xlsx, .xls, .csv" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">นำเข้าข้อมูล</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Import File -->

            <a type="button" class="btn btn-secondary" href="{{ url('/admin/export') }}">ส่งออกข้อมูล</a>

            <a type="button" class="btn btn-success" href="/admin/addrecord"><i
                    class="fa-solid fa-plus"></i>&nbsp;เพิ่มข้อมูล</a>
        </div>
    </div>

    <div class="rectangle-box">
        <form action="{{ route('recorddata.search') }}" method="GET">
            <div class="form-group-horizontal">
                <div class="form-group">
                    <label for="id_card">เลขบัตรประจำตัวประชาชน</label>
                    <div class="input-group">
                        <input id="id_card" class="form-control" type="text" name="id_card"
                            placeholder="ค้นหาเลขบัตรประชาชน" aria-label="Search" maxlength="13">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">ชื่อ-นามสกุล</label>
                    <div class="input-group">
                        <input id="name" class="form-control" type="search" name="name" placeholder="ค้นหาชื่อ-นามสกุล"
                            aria-label="Search">
                    </div>
                </div>

                <div class="form-group">
                    <label for="housenumber">บ้านเลขที่</label>
                    <div class="input-group">
                        <input id="housenumber" class="form-control" type="search" name="housenumber"
                            placeholder="ค้นหาบ้านเลขที่" aria-label="Search">
                    </div>
                </div>

                <div class="form-group">
                    <label for="diseases">โรคประจำตัว</label>
                    <select id="diseases" class="form-control" name="diseases">
                        <option value="">เลือกโรคประจำตัว</option>
                        @php
                        $diseases = [
                        'diabetes' => 'เบาหวาน',
                        'cerebral_artery' => 'หลอดเลือดสมอง',
                        'kidney' => 'โรคไต',
                        'blood_pressure' => 'ความดันโลหิตสูง',
                        'heart' => 'โรคหัวใจ',
                        'eye' => 'โรคตา',
                        'other' => 'โรคอื่นๆ'
                        ];
                        @endphp
                        @foreach($diseases as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">ค้นหา</button>
                </div>
            </div>
        </form>
    </div>

    @php
    use Carbon\Carbon;
    @endphp

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">เลขบัตรประจำตัวประชาชน</th>
                    <th scope="col">ชื่อ-นามสกุล</th>
                    <th scope="col">บ้านเลขที่</th>
                    <th scope="col">วัน/เดือน/ปีเกิด</th>
                    <th scope="col">อายุ</th>
                    <th scope="col">เบอร์โทรศัพท์</th>
                    <th scope="col">โรคประจำตัว</th>
                    <th scope="col">การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recorddata as $key => $data)
                <tr>
                    <td><strong>{{ $recorddata->total() - (($recorddata->currentPage() - 1) * $recorddata->perPage()) - $loop->iteration + 1 }}</strong>
                    </td>
                    <td><strong>{{ $data['id_card'] }}</strong></td>
                    <td><strong>{{ $data['name'] }} {{ $data['surname'] }}</strong></td>
                    <td><strong>{{ $data['housenumber'] }}</strong></td>
                    <td><strong>{{ Carbon::parse($data['birthdate'])->format('d/m/Y') }}</strong></td>
                    <td><strong>{{ $data['age'] }}</strong></td>
                    <td><strong>{{ $data['phone'] }}</strong></td>
                    <td><strong>
                            @if($data->diseases)
                            @php
                            $diseaseLabels = [
                            'diabetes' => 'เบาหวาน',
                            'cerebral_artery' => 'หลอดเลือดสมอง',
                            'kidney' => 'โรคไต',
                            'blood_pressure' => 'ความดันโลหิตสูง',
                            'heart' => 'โรคหัวใจ',
                            'eye' => 'โรคตา',
                            'other' => 'โรคอื่นๆ'
                            ];

                            $selectedDiseases = collect($data->diseases->toArray())
                            ->filter(fn($value, $key) => $value == 1 && isset($diseaseLabels[$key]))
                            ->keys()
                            ->map(fn($key) => $diseaseLabels[$key])
                            ->implode("\n");
                            @endphp
                            {!! nl2br(e($selectedDiseases) ?: 'ไม่มีโรคประจำตัว') !!}
                            @else
                            -
                            @endif
                        </strong></td>

                    <td>

                        <a href="{{ route('recorddata.update', $data->id) }}" type="button"
                            class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <form id="deleteForm{{ $data->id }}"
                            action="{{ route('recorddata.destroy', ['id' => $data->id]) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-button" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $data->id }}" data-id="{{ $data->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                        <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $data->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $data->id }}"
                                            style="color:#000;">
                                            ยืนยันการลบ</h5>
                                        <button type="button" class="btn btn-light rounded-circle shadow-sm close-btn"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>
                                    <div class="modal-body" style="color:#000;">
                                        คุณต้องการลบข้อมูลนี้ใช่หรือไม่?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ไม่</button>
                                        <button type="button" class="btn btn-danger confirmDelete"
                                            data-form-id="deleteForm{{ $data->id }}">ยืนยันการลบ</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        // เมื่อกดปุ่ม "ยืนยันการลบ"
                        document.querySelectorAll('.confirmDelete').forEach(button => {
                            button.addEventListener('click', function() {
                                var formId = this.getAttribute(
                                    'data-form-id'); // ดึง ID ของฟอร์มที่ต้องการส่ง
                                var form = document.getElementById(formId); // หาฟอร์มที่มี ID นี้
                                console.log('Submitting form with ID: ' +
                                    formId); // เช็คว่า ID ของฟอร์มถูกดึงมาไหม
                                form.submit(); // ส่งฟอร์ม
                            });
                        });
                        </script>


                        <button class="btn btn-warning btn-sm"><i class="fa-solid fa-print"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="custom-pagination mt-3">
            @if ($recorddata->onFirstPage())
            <span class="disabled">ย้อนกลับ</span>
            @else
            <a href="{{ $recorddata->previousPageUrl() }}">ย้อนกลับ</a>
            @endif

            <span>ทั้งหมด {{ $recorddata->total() }} รายการ</span>

            @if ($recorddata->hasMorePages())
            <a href="{{ $recorddata->nextPageUrl() }}">ถัดไป</a>
            @else
            <span class="disabled">ถัดไป</span>
            @endif
        </div>

        <br>
    </div>
    @endsection