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

.custom-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    padding: 12px;
    font-size: 16px;
}

.custom-pagination a,
.custom-pagination span {
    padding: 8px 16px;
    background-color: #5a5d61;
    /* เทาเข้ม */
    color: #ffffff;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.custom-pagination a:hover {
    background-color: #4d5054;
    /* เทาเข้มขึ้นเมื่อ hover */
    transform: translateY(-2px);
}

.custom-pagination .active {
    background-color: #343a40;
    /* เทาดำ */
    font-weight: bold;
}

.custom-pagination .disabled {
    background-color: #bcbec2;
    /* เทาหม่นอ่อน */
    color: #6c757d;
    cursor: not-allowed;
}

.custom-pagination .disabled:hover {
    background-color: #bcbec2;
    /* ไม่เปลี่ยนสีเมื่อ hover */
}

/* ปรับขนาดปุ่ม success */
.btn-success {
    padding: 6px 12px; /* ลดขนาด padding */
    font-size: 14px; /* ลดขนาดตัวหนังสือ */
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-success:hover {
    background-color: #218838;
}

/* ปรับขนาดปุ่ม danger */
.btn-danger {
    padding: 6px 12px; /* ลดขนาด padding */
    font-size: 14px; /* ลดขนาดตัวหนังสือ */
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-danger:hover {
    background-color: #c82333;
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

@media (max-width: 768px) {

    th,
    td {
        font-size: 12px;
        padding: 10px;
    }

    .btn {
        padding: 6px 12px;
        font-size: 12px;
    }

    .title {
        font-size: 16px;
    }

    .alert {
        font-size: 12px;
    }

    .custom-pagination {
        font-size: 12px;
    }

    .custom-pagination a,
    .custom-pagination span {
        font-size: 12px;
    }

    .btn-cancel,
    .btn-confirm {
        font-size: 12px;
    }

    table {
        width: 100%;
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    th,
    td {
        white-space: nowrap;
    }
}
</style>

<div class="container py-3">
    <br>
    <div class="box">
        <div class="title">
            ลบล่าสุด
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>เลขบัตรประชาชน</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>บ้านเลขที่</th>
                    <th>วันเกิด</th>
                    <th>อายุ</th>
                    <th>เบอร์โทร</th>
                    <th>โรคประจำตัว</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deletedRecords as $record)
                <tr>
                    <td><strong>{{ $deletedRecords->firstItem() + $loop->index }}</strong></td>
                    <td><strong>{{ $record->id_card }}</strong></td>
                    <td><strong>{{ $record->name }} {{ $record->surname }}</strong></td>
                    <td><strong>{{ $record->housenumber }}</strong></td>
                    <td><strong>{{ \Carbon\Carbon::parse($record->birthdate)->translatedFormat('d F Y') }}</strong></td>
                    <td><strong>{{ $record->age }}</strong></td>
                    <td><strong>{{ $record->phone }}</strong></td>
                    <td><strong>
                            @if($record->diseases)
                            @php
                            $diseaseLabels = [
                            'diabetes' => 'เบาหวาน',
                            'cerebral_artery' => 'หลอดเลือดสมอง',
                            'kidney' => 'โรคไต',
                            'blood_pressure' => 'ความดันโลหิตสูง',
                            'heart' => 'โรคหัวใจ',
                            'eye' => 'โรคตา'
                            ];

                            $selectedDiseases = collect($record->diseases->toArray())
                            ->filter(fn($value, $key) => $value == 1 && isset($diseaseLabels[$key]))
                            ->keys()
                            ->map(fn($key) => $diseaseLabels[$key])
                            ->implode("\n");

                            // ถ้ามีข้อมูล 'other' และ 'other_text' จะเชื่อมต่อโดยไม่เว้นบรรทัด
                            if ($record->diseases->other && !empty($record->diseases->other_text)) {
                            $selectedDiseases .= $selectedDiseases ? ' ' . $record->diseases->other_text :
                            $record->diseases->other_text;
                            }
                            @endphp
                            {!! nl2br(e($selectedDiseases) ?: 'ไม่มีโรคประจำตัว') !!}
                            @else
                            -
                            @endif
                        </strong></td>
                    <td>
                        <!-- ปุ่มกู้คืนพร้อม Modal -->
                        <button class="btn btn-success btn-custom" data-bs-toggle="modal"
                            data-bs-target="#restoreModal{{ $record->id }}">กู้คืน</button>

                        <!-- Modal สำหรับกู้คืน -->
                        <div class="modal fade" id="restoreModal{{ $record->id }}" tabindex="-1"
                            aria-labelledby="restoreModalLabel{{ $record->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="restoreModalLabel{{ $record->id }}"
                                            style="color: #000;">
                                            ยืนยันการกู้คืนข้อมูล</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="color: #000;">
                                        คุณต้องการกู้คืนข้อมูลของ <strong>{{ $record->name }}
                                            {{ $record->surname }}</strong> หรือไม่?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ยกเลิก</button>
                                        <form action="{{ route('recorddata.restore', ['id' => $record->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">กู้คืน</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ปุ่มลบถาวรพร้อม Modal -->
                        <button class="btn btn-danger btn-custom" data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $record->id }}">ลบ</button>

                        <!-- Modal สำหรับลบถาวร -->
                        <div class="modal fade" id="deleteModal{{ $record->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $record->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $record->id }}"
                                            style="color: #000;">ยืนยันการลบข้อมูล
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="color: #000;">
                                        คุณต้องการลบข้อมูล <strong>{{ $record->name }} {{ $record->surname }}</strong>
                                        อย่างถาวรหรือไม่?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ยกเลิก</button>
                                        <form
                                            action="{{ route('recorddata.destroyPermanently', ['id' => $record->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">ลบถาวร</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="custom-pagination mt-3 flex items-center gap-2">
            {{-- ปุ่มย้อนกลับ --}}
            @if ($deletedRecords->onFirstPage())
            <span class="disabled text-gray-400 px-3 py-2 border rounded-md cursor-not-allowed">ย้อนกลับ</span>
            @else
            <a href="{{ $deletedRecords->previousPageUrl() }}"
                class="px-3 py-2 border rounded-md hover:bg-gray-200">ย้อนกลับ</a>
            @endif

            {{-- แสดงหมายเลขหน้าแบบกระชับ --}}
            @php
            $totalPages = $deletedRecords->lastPage();
            $currentPage = $deletedRecords->currentPage();
            $sidePages = 2; // จำนวนหน้าที่แสดงรอบๆ หน้าปัจจุบัน
            @endphp

            {{-- หน้าแรก --}}
            @if ($currentPage > 1 + $sidePages)
            <a href="{{ $deletedRecords->url(1) }}" class="px-3 py-2 border rounded-md hover:bg-gray-200">1</a>
            @if ($currentPage > 2 + $sidePages)
            <span class="px-2">...</span>
            @endif
            @endif

            {{-- แสดงหน้ารอบๆ ปัจจุบัน --}}
            @for ($page = max(1, $currentPage - $sidePages); $page <= min($totalPages, $currentPage + $sidePages);
                $page++) @if ($page==$currentPage) <span class="bg-blue-500 text-white px-3 py-2 border rounded-md">
                {{ $page }}
                </span>
                @else
                <a href="{{ $deletedRecords->url($page) }}"
                    class="px-3 py-2 border rounded-md hover:bg-gray-200">{{ $page }}</a>
                @endif
                @endfor

                {{-- หน้าสุดท้าย --}}
                @if ($currentPage < $totalPages - $sidePages) @if ($currentPage < $totalPages - $sidePages - 1) <span
                    class="px-2">...</span>
                    @endif
                    <a href="{{ $deletedRecords->url($totalPages) }}"
                        class="px-3 py-2 border rounded-md hover:bg-gray-200">{{ $totalPages }}</a>
                    @endif

                    {{-- ปุ่มถัดไป --}}
                    @if ($deletedRecords->hasMorePages())
                    <a href="{{ $deletedRecords->nextPageUrl() }}"
                        class="px-3 py-2 border rounded-md hover:bg-gray-200">ถัดไป</a>
                    @else
                    <span class="disabled text-gray-400 px-3 py-2 border rounded-md cursor-not-allowed">ถัดไป</span>
                    @endif
        </div>
    </div>
</div>

@endsection