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

<div class="container mt-4">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>ข้อมูลที่ถูกซ่อน</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>ชื่อข้อมูล</th>
                            <th>วันที่ซ่อน</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deletedRecords as $record)
                        <tr>
                            <td>{{ $record->name }}</td>
                            <td>{{ $record->updated_at }}</td>
                            <td>
                                <form action="{{ route('recorddata.restore', ['id' => $record->id]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">กู้คืน</button>
                                </form>

                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteModal{{ $record->id }}">ลบถาวร</button>

                                <div class="modal fade" id="deleteModal{{ $record->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">ยืนยันการลบข้อมูล</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                คุณต้องการลบข้อมูล <strong>{{ $record->name }}</strong>
                                                อย่างถาวรหรือไม่?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">ยกเลิก</button>
                                                <form
                                                    action="{{ route('recorddata.destroyPermanently', ['id' => $record->id]) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">ลบถาวร</button>
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
            </div>
        </div>
    </div>
</div>

@endsection