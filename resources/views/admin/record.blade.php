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
    color: #fff !important;
    /* ใช้ !important เพื่อบังคับให้ตัวหนังสือเป็นสีขาว */
    text-align: center;
}

.table td {
    background-color: #7DA7D8;
    color: #fff !important;
    word-wrap: break-word;
    max-width: 200px;
    text-align: center;
}

.table td:hover,
.table th:hover {
    color: #fff !important;
}

.rectangle-box {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin: 20px;
}

.form-group-horizontal {
    display: flex;
    flex-wrap: nowrap;
    overflow: hidden;
}

.form-group {
    min-width: 200px;
    /* ขนาดขั้นต่ำของแต่ละฟอร์มกลุ่ม */
    margin-right: 15px;
    /* เว้นระยะระหว่างฟอร์มกลุ่ม */
}

button.btn-primary {
    flex: 1 1 100%;
    font-size: 14px;
    padding: 12px 20px;
    margin-top: 10px;
}

label {
    font-size: 14px;
    font-weight: bold;
    color: #020364;
    margin-bottom: 8px;
}

.input-group {
    position: relative;
}

.form-control {
    border-radius: 30px;
    padding: 12px 20px;
    border: 1px solid #ddd;
    box-sizing: border-box;
    width: 100%;
    font-size: 14px;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
}

select.form-control {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 35px;
}

button.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.custom-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    padding: 12px;
    font-size: 16px;
}

/* สีปุ่มปกติ */
.custom-pagination a,
.custom-pagination span {
    padding: 8px 16px;
    background-color: #198754;
    /* เขียว Bootstrap btn-success */
    color: #ffffff;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* เมื่อ hover */
.custom-pagination a:hover {
    background-color: #157347;
    /* เขียวเข้มขึ้นเล็กน้อย */
    transform: translateY(-2px);
}

/* ปุ่มที่ถูกเลือก (active) */
.custom-pagination .active {
    background-color: #146c43;
    /* เขียวเข้ม Bootstrap */
    font-weight: bold;
}

/* ปุ่มที่ไม่สามารถกดได้ (disabled) */
.custom-pagination .disabled {
    background-color: #A3D9A5;
    /* เขียวอ่อนแบบซอฟต์ */
    color: #5C9A5A;
    cursor: not-allowed;
}

/* ป้องกันสีเปลี่ยนเมื่อ hover */
.custom-pagination .disabled:hover {
    background-color: #A3D9A5;
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

#previewTable {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    /* ช่วยให้คอลัมน์กว้างเท่ากัน */
}

#previewTable th,
#previewTable td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: left;
    white-space: nowrap;
    /* ป้องกันข้อความขึ้นบรรทัดใหม่ */
}


@media (max-width: 768px) {

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

    .rectangle-box {
        display: flex;
        flex-direction: column;
        max-height: 400px;
        /* กำหนดความสูงสูงสุด */
        overflow-y: auto;
        /* ให้เลื่อนในแนวตั้งได้ */
        padding: 15px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group-horizontal {
        display: flex;
        flex-direction: column;
        /* จัดให้อยู่ในแนวตั้ง */
        gap: 10px;
        /* เพิ่มระยะห่าง */
    }

    .form-group {
        display: flex;
        flex-direction: column;
        width: 100%;
        /* ให้ input ขยายเต็ม div */
        min-width: 200px;
    }

    .btn-primary {
        width: 100%;
    }

    /* ปรับขนาด label และ input */
    .form-group label {
        font-size: 12px;
        /* ขนาดฟอนต์เล็กลง */
    }

    .input-group .form-control {
        padding: 8px 15px;
        /* เพิ่มการเติมภายใน */
    }

    .input-group-text {
        padding: 8px;
        /* เพิ่มการเติมภายใน */
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
        font-size: 12px;
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
        font-size: 12px;
    }

    .modal-body .form-control {
        padding: 8px;
        font-size: 12px;
    }

    .modal-body .btn-primary {
        padding: 10px;
        font-size: 12px;
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
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">นำเข้าข้อมูล</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="uploadForm" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="excelFile" class="form-label fw-bold">เลือกไฟล์ Excel หรือ CSV</label>
                                    <input type="file" class="form-control" id="excelFile" name="file"
                                        accept=".xlsx, .xls, .csv" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">นำเข้าข้อมูล</button>
                            </form>

                            <!-- ส่วนแสดงตัวอย่างข้อมูล -->
                            <h5 class="mt-4">ตัวอย่างข้อมูล</h5>
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-bordered" id="previewTable">
                                    <thead>
                                        <tr id="tableHead"></tr>
                                    </thead>
                                    <tbody id="tableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            document.getElementById('excelFile').addEventListener('change', function(event) {
                let file = event.target.files[0];
                if (!file) return;

                let reader = new FileReader();
                reader.onload = function(e) {
                    let data = new Uint8Array(e.target.result);
                    let workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    let firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    let jsonData = XLSX.utils.sheet_to_json(firstSheet, {
                        header: 1
                    });

                    displayPreview(jsonData);
                };
                reader.readAsArrayBuffer(file);
            });

            function displayPreview(data) {
                let tableHead = document.getElementById('tableHead');
                let tableBody = document.getElementById('tableBody');

                tableHead.innerHTML = "";
                tableBody.innerHTML = "";

                if (data.length === 0) return;

                // ดึง Header (แถวแรก)
                let headers = data[0];
                let columnCount = headers.length;

                // สร้างหัวตาราง
                let headerRow = document.createElement('tr');
                headers.forEach(header => {
                    let th = document.createElement('th');
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                tableHead.appendChild(headerRow);

                // สร้างข้อมูลในตารางให้จำนวนคอลัมน์ตรงกัน
                data.slice(1).forEach(rowData => {
                    let row = document.createElement('tr');

                    for (let i = 0; i < columnCount; i++) {
                        let td = document.createElement('td');
                        td.textContent = rowData[i] || ""; // ถ้าข้อมูลไม่มีให้เติมค่าว่าง
                        row.appendChild(td);
                    }

                    tableBody.appendChild(row);
                });
            }
            </script>

            <!--  Export File -->
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
                        <option value="{{ $key }}" {{ request('diseases') == $key ? 'selected' : '' }}>{{ $value }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">ค้นหา</button>
                </div>
            </div>
        </form>
    </div>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var toggler = document.querySelector('.navbar-toggler');
        toggler.addEventListener('click', function() {
            var navbar = document.getElementById('navbarNav');
            navbar.classList.toggle('show');
        });
    });
    </script>

    @php
    use Carbon\Carbon;
    @endphp

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ลำดับที่</th>
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
                    <td><strong>{{ ($recorddata->firstItem() + $loop->index) }}</strong></td>
                    </td>
                    <td><strong>{{ $data['id_card'] }}</strong></td>
                    <td><strong>{{ $data['name'] }} {{ $data['surname'] }}</strong></td>
                    <td><strong>{{ $data['housenumber'] }}</strong></td>
                    <td><strong>{{ \Carbon\Carbon::parse($data['birthdate'])->translatedFormat('d') }}/{{ \Carbon\Carbon::parse($data['birthdate'])->translatedFormat('F') }}/{{ \Carbon\Carbon::parse($data['birthdate'])->year + 543 }}
                        </strong>
                    </td>
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
                            'eye' => 'โรคตา'
                            ];

                            $selectedDiseases = collect($data->diseases->toArray())
                            ->filter(fn($value, $key) => $value == 1 && isset($diseaseLabels[$key]))
                            ->keys()
                            ->map(fn($key) => $diseaseLabels[$key])
                            ->implode("\n");

                            // ถ้าเลือก 'other' และมีค่า other_text ให้แสดงแค่ other_text
                            if ($data->diseases->other && !empty($data->diseases->other_text)) {
                            $selectedDiseases .= "" . $data->diseases->other_text;
                            }
                            @endphp
                            {!! nl2br(e($selectedDiseases) ?: 'ไม่มีโรคประจำตัว') !!}
                            @else
                            -
                            @endif
                        </strong></td>
                    <td>

                        <a href="{{ route('recorddata.update', $data->id) }}" type="button"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>
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

                        <a href="{{ route('admin.print', ['id' => $data->id]) }}" target="_blank"
                            class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-print"></i>
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="custom-pagination mt-3 flex items-center gap-2">
            {{-- ปุ่มย้อนกลับ --}}
            @if ($recorddata->onFirstPage())
            <span class="disabled text-gray-400 px-3 py-2 border rounded-md cursor-not-allowed">ย้อนกลับ</span>
            @else
            <a href="{{ $recorddata->previousPageUrl() }}"
                class="px-3 py-2 border rounded-md hover:bg-gray-200">ย้อนกลับ</a>
            @endif

            {{-- แสดงหมายเลขหน้าแบบกระชับ --}}
            @php
            $totalPages = $recorddata->lastPage();
            $currentPage = $recorddata->currentPage();
            $sidePages = 2; // จำนวนหน้าที่แสดงรอบๆ หน้าปัจจุบัน
            @endphp

            {{-- หน้าแรก --}}
            @if ($currentPage > 1 + $sidePages)
            <a href="{{ $recorddata->url(1) }}" class="px-3 py-2 border rounded-md hover:bg-gray-200">1</a>
            @if ($currentPage > 2 + $sidePages)
            <span class="px-2">...</span>
            @endif
            @endif

            {{-- แสดงหน้ารอบๆ ปัจจุบัน --}}
            @for ($page = max(1, $currentPage - $sidePages); $page <= min($totalPages, $currentPage + $sidePages);
                $page++) @if ($page==$currentPage) <span class="bg-blue-500 text-white px-3 py-2 border rounded-md">
                {{ $page }}</span>
                @else
                <a href="{{ $recorddata->url($page) }}"
                    class="px-3 py-2 border rounded-md hover:bg-gray-200">{{ $page }}</a>
                @endif
                @endfor

                {{-- หน้าสุดท้าย --}}
                @if ($currentPage < $totalPages - $sidePages) @if ($currentPage < $totalPages - $sidePages - 1) <span
                    class="px-2">...</span>
                    @endif
                    <a href="{{ $recorddata->url($totalPages) }}"
                        class="px-3 py-2 border rounded-md hover:bg-gray-200">{{ $totalPages }}</a>
                    @endif

                    {{-- ปุ่มถัดไป --}}
                    @if ($recorddata->hasMorePages())
                    <a href="{{ $recorddata->nextPageUrl() }}"
                        class="px-3 py-2 border rounded-md hover:bg-gray-200">ถัดไป</a>
                    @else
                    <span class="disabled text-gray-400 px-3 py-2 border rounded-md cursor-not-allowed">ถัดไป</span>
                    @endif
        </div>

        <br>
    </div>
</div>
@endsection