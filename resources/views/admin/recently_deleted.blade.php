@extends('layoutadmin')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        { session('success') !!}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

<table class="table">
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
                    <form action="{{ route('recorddata.destroyPermanently', ['id' => $record->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">ลบถาวร</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
