@extends('layoutuser')

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
    color: #fff !important; /* ใช้ !important เพื่อบังคับให้ตัวหนังสือเป็นสีขาว */
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
        overflow-x: auto; /* ทำให้สามารถเลื่อนในแนวนอนได้ */
    }

    .form-group-horizontal {
        display: flex;
        flex-wrap: nowrap; /* ป้องกันไม่ให้ฟอร์มย่อในแนวนอน */
        overflow-x: auto; /* ทำให้สามารถเลื่อนในแนวนอนได้ */
    }

    .form-group {
        min-width: 200px; /* ขนาดขั้นต่ำของแต่ละฟอร์มกลุ่ม */
        margin-right: 15px; /* เว้นระยะระหว่างฟอร์มกลุ่ม */
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

    .form-group-horizontal {
        gap: 10px;
        /* ลดระยะห่างระหว่างช่องค้นหา */
        overflow-x: auto;
        /* ให้สามารถเลื่อนในแนวนอนได้ */
    }

    .form-group {
        flex: 1 1 200px;
        /* ช่องค้นหาทุกช่องมีขนาดยืดหยุ่น */
        min-width: 150px;
        /* กำหนดขนาดขั้นต่ำ */
        max-width: 200px;
        /* กำหนดขนาดสูงสุด */
        margin-right: 10px;
    }

    button.btn-primary {
        flex: 1 1 100%;
        margin-top: 15px;
        padding: 12px 20px;
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
    </div>

    <div class="rectangle-box">
        <form action="{{ route('recorddata.Usersearch') }}" method="GET">
            <div class="form-group-horizontal">

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
                    <option value="{{ $key }}" {{ request('diseases') == $key ? 'selected' : '' }}>{{ $value }}</option>
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
                    <th scope="col">ลำดับที่</th>
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

                        <a href="{{ route('recorddata.view', $data->id) }}" type="button"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
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