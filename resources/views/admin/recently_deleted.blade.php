@extends('layoutadmin')

@section('content')

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

<div class="container">
    <table class="table table-bordered table-striped">
        <thead>
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
                        <!-- ฟอร์มสำหรับกู้คืนข้อมูล -->
                        <form action="{{ route('recorddata.restore', ['id' => $record->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">กู้คืน</button>
                        </form>
                        
                        <!-- ฟอร์มสำหรับลบถาวร -->
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $record->id }}">ลบถาวร</button>
                        
                        <!-- Modal ยืนยันการลบ -->
                        <div class="modal fade" id="deleteModal{{ $record->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">ยืนยันการลบข้อมูล</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        คุณต้องการลบข้อมูล <strong>{{ $record->name }}</strong> อย่างถาวรหรือไม่?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                        <form action="{{ route('recorddata.destroyPermanently', ['id' => $record->id]) }}" method="POST" style="display:inline;">
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
</div>

@endsection