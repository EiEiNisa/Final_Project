@extends('layoutadmin')

@section('content')
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
                    <form action="{{ route('recorddata.restore', ['id' => $record->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">กู้คืน</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection