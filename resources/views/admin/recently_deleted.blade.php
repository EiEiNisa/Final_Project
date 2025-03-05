@extends('layoutadmin')

@section('content')

<style>
/* ปรับขนาด card header ให้ใหญ่ขึ้น */
.card-header {
    background-color: #4e73df;
    color: white;
    font-size: 1.5rem; /* เพิ่มขนาดตัวอักษรให้ใหญ่ขึ้น */
    padding: 1rem 1.5rem; /* ปรับ padding ใหญ่ขึ้น */
}

.card-header h4 {
    margin-bottom: 0;
    font-weight: bold;
}

/* ปรับสีตาราง */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #dee2e6; /* ขอบสีอ่อน */
    padding: 0.75rem; /* เพิ่มช่องว่างในเซลล์ */
    font-size: 0.9rem; /* ลดขนาดตัวอักษรในตาราง */
}

th {
    background-color: #f8f9fc; /* สีพื้นหลังของหัวตาราง */
    color: #333; /* สีตัวหนังสือในหัวตาราง */
    font-weight: bold;
}

td {
    background-color: #fff; /* สีพื้นหลังของแถวข้อมูล */
    color: #495057; /* สีตัวหนังสือในแถวข้อมูล */
}

tr:nth-child(even) td {
    background-color: #f1f3f5; /* สีพื้นหลังของแถวที่เป็นเลขคู่ */
}

/* ปรับปุ่มให้เล็กลง */
.btn-sm {
    padding: 0.25rem 0.5rem; /* ลดขนาด padding ของปุ่ม */
    font-size: 0.75rem; /* ลดขนาดตัวอักษรในปุ่ม */
    line-height: 1.25;
    border-radius: 0.25rem;
}

/* ปรับสี alert */
.alert-success {
    background-color: #28a745;
    color: white;
}

.alert-danger {
    background-color: #dc3545;
    color: white;
}

/* ปรับการแสดง Modal */
.modal-content {
    border-radius: 0.5rem;
}

.modal-header {
    background-color: #f8f9fc;
}

.modal-footer button {
    border-radius: 0.3rem;
}

/* การจัดการการแสดงผลของ pagination */
.custom-pagination {
    display: flex;
    justify-content: center;
}

.custom-pagination a,
.custom-pagination span {
    padding: 8px 16px;
    background-color: #6c757d;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    margin: 0;
}

.custom-pagination a:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.custom-pagination .active {
    background-color: #495057;
    font-weight: bold;
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
}

.custom-pagination .disabled {
    background-color: #d6d8db;
    color: #868e96;
    cursor: not-allowed;
    box-shadow: none;
    opacity: 0.6;
}

.custom-pagination .disabled:hover {
    background-color: #d6d8db;
}
</style>


<!-- การแจ้งเตือน Success/Error -->
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

<!-- ส่วนหัวของหน้า -->
<div class="card">
    <div class="card-header">
        <h4>ข้อมูลที่ถูกลบ (Recently Deleted Records)</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
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
                                        <h5 class="modal-title" id="restoreModalLabel{{ $record->id }}">
                                            ยืนยันการกู้คืนข้อมูล</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
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
                            data-bs-target="#deleteModal{{ $record->id }}">ลบถาวร</button>

                        <!-- Modal สำหรับลบถาวร -->
                        <div class="modal fade" id="deleteModal{{ $record->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $record->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $record->id }}">ยืนยันการลบข้อมูล
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
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