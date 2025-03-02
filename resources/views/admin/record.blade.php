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
    overflow-x: auto;
    /* ทำให้สามารถเลื่อนในแนวนอนได้ */
}

.form-group-horizontal {
    display: flex;
    flex-wrap: nowrap;
    /* ป้องกันไม่ให้ฟอร์มย่อในแนวนอน */
    overflow-x: auto;
    /* ทำให้สามารถเลื่อนในแนวนอนได้ */
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
                                        ที่ต้องการนำเข้า (.csv) </label>
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

        <div class="flex flex-col items-center">
            <!-- Pagination Component -->
            <div class="flex items-center gap-1">
                <button
                    class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed focus:shadow-none text-sm rounded-md py-2 px-4 bg-transparent border-transparent text-stone-800 hover:bg-stone-800/5 hover:border-stone-800/5 shadow-none hover:shadow-none">
                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" color="currentColor" class="mr-1.5 h-4 w-4 stroke-2">
                        <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                    Previous
                </button>
                <button
                    class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[38px] min-h-[38px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-800/5 hover:border-stone-800/5 shadow-none hover:shadow-none">
                    1
                </button>
                <button
                    class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[38px] min-h-[38px] rounded-md shadow-sm hover:shadow-md bg-stone-800 border-stone-800 text-stone-50 hover:bg-stone-700 hover:border-stone-700">
                    2
                </button>
                <button
                    class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[38px] min-h-[38px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-800/5 hover:border-stone-800/5 shadow-none hover:shadow-none">
                    3
                </button>
                <button
                    class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[38px] min-h-[38px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-800/5 hover:border-stone-800/5 shadow-none hover:shadow-none">
                    4
                </button>
                <button
                    class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[38px] min-h-[38px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-800/5 hover:border-stone-800/5 shadow-none hover:shadow-none">
                    5
                </button>
                <button
                    class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed focus:shadow-none text-sm rounded-md py-2 px-4 bg-transparent border-transparent text-stone-800 hover:bg-stone-800/5 hover:border-stone-800/5 shadow-none hover:shadow-none">
                    Next
                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" color="currentColor" class="ml-1.5 h-4 w-4 stroke-2">
                        <path d="M9 6L15 12L9 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Centered Note -->
            <p class="text-center mt-4 text-sm text-gray-700">
                Inspired by
                <a href="https://www.creative-tim.com/david-ui/docs/html/pagination"
                    class="text-blue-600 hover:underline" target="_blank" rel="noopener noreferrer">
                    David UI
                </a>
                Framework
            </p>
        </div>
        <br>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentPage = 1; // ตั้งค่าหน้าเริ่มต้น
        const totalPages = 5; // จำนวนหน้าทั้งหมด
        const buttons = document.querySelectorAll(".pagination-btn");
        const contentContainer = document.getElementById("content"); // ส่วนที่เปลี่ยนเนื้อหา

        function changePage(newPage) {
            if (newPage < 1 || newPage > totalPages) return;
            currentPage = newPage;

            // อัปเดตสไตล์ของปุ่ม
            buttons.forEach((btn) => {
                if (!isNaN(btn.innerText)) {
                    btn.classList.remove("bg-stone-800", "text-stone-50", "shadow-sm");
                    btn.classList.add("bg-transparent", "text-stone-800");
                    if (parseInt(btn.innerText) === currentPage) {
                        btn.classList.add("bg-stone-800", "text-stone-50", "shadow-sm");
                        btn.classList.remove("bg-transparent", "text-stone-800");
                    }
                }
            });

            // อัปเดตเนื้อหาตามหน้าที่เลือก
            contentContainer.innerHTML = `<p class="text-lg font-bold">เนื้อหาของหน้า ${currentPage}</p>`;
        }

        buttons.forEach((btn) => {
            btn.addEventListener("click", function() {
                if (btn.innerText === "Previous") {
                    changePage(currentPage - 1);
                } else if (btn.innerText === "Next") {
                    changePage(currentPage + 1);
                } else if (!isNaN(btn.innerText)) {
                    changePage(parseInt(btn.innerText));
                }
            });
        });

        changePage(1); // โหลดหน้าแรก
    });
    </script>

</div>

@endsection