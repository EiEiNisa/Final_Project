@extends('layoutadmin')

@section('content')
<style>
.card-header h4 {
    margin-bottom: 0;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}
</style>

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

<div class="container">
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

                        if ($record->diseases->other && !empty($record->diseases->other_text)) {
                        $selectedDiseases .= "\n" . $record->diseases->other_text;
                        }
                        @endphp
                        {!! nl2br(e($selectedDiseases) ?: 'ไม่มีโรคประจำตัว') !!}
                        @else
                        -
                        @endif
                    </strong></td>
                <td>
                    <!-- ปุ่มกู้คืนพร้อม Modal -->
                    <button class="btn btn-success" data-bs-toggle="modal"
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
                    <button class="btn btn-danger" data-bs-toggle="modal"
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
                                    <form action="{{ route('recorddata.destroyPermanently', ['id' => $record->id]) }}"
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

    <!-- Pagination -->
    {{ $deletedRecords->links() }}
</div>

@endsection