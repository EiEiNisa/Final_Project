@extends('layoutadmin')

@section('content')
<style>
.title {
    color: #020364;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.table {

    margin-top: 10px;
    margin-bottom: 10px;
}

.table th {
    background-color: #020364;
    color: #fff;
}

.table td {
    background-color: #7DA7D8;
    color: #fff;
    word-wrap: break-word;
    max-width: 200px;
}

.table td:nth-child(2) {
    max-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

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
    /* ระยะห่างระหว่างช่องค้นหาต่าง ๆ */
}

.form-group {
    flex: 1;
    min-width: 200px;
    /* ทำให้ช่องกรอกข้อมูลไม่แคบเกินไป */
}

label {
    font-size: 14px;
    font-weight: bold;
    color: #333;
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
}

.input-group-text {
    background-color: #e7e7e7;
    border: none;
    border-radius: 50%;
    padding: 10px;
    margin-left: -30px;
    cursor: pointer;
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
        <div>
            <!--Import File-->
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
            <!--Import File-->

            <a type="button" class="btn btn-secondary" href="{{ url('/admin/export') }}">ส่งออกข้อมูล</a>

            <a type="button" class="btn btn-success" href="/admin/addrecord"><i
                    class="fa-solid fa-plus"></i>&nbsp;เพิ่มข้อมูลส่วนตัว</a>
        </div>
    </div>

    <div class="rectangle-box">
        <form action="{{ route('recorddata.search') }}" method="GET">
            <div class="form-group-horizontal">
                <div class="form-group">
                    <label for="id_card">เลขบัตรประจำตัวประชาชน</label>
                    <div class="input-group">
                        <input id="id_card" class="form-control" type="search" name="id_card"
                            placeholder="ค้นหาเลขบัตรประชาชน" aria-label="Search">
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

    <table class="table table-striped table-bordere table-hover">
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
                <td scope="row">
                    <strong>{{ $recorddata->total() - (($recorddata->currentPage() - 1) * $recorddata->perPage()) - $loop->iteration + 1 }}</strong>
                </td>

                <td><strong>{{ $data['id_card'] }}</strong></td>
                <td><strong>{{ $data['name'] }} {{ $data['surname'] }}</strong></td>
                <td style="text-align: center;"><strong>{{ $data['housenumber'] }}</strong></td>
                <td style="text-align: center;">
                    <strong>{{ Carbon::parse($data['birthdate'])->format('d/m/Y') }}</strong>
                </td>
                <td style="text-align: center;"><strong>{{ $data['age'] }}</strong></td>
                <td style="text-align: center;"><strong>{{ $data['phone'] }}</strong></td>
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

                    <a href="{{ route('recorddata.update', $data->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <form id="deleteForm{{ $data->id }}" action="{{ route('recorddata.destroy', ['id' => $data->id]) }}"
                        method="POST" style="display:inline;">
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
                                    <h5 class="modal-title" id="deleteModalLabel{{ $data->id }}" style="color:#000;">
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
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