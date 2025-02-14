@extends('layoutadmin')

@section('content')

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept=".xlsx, .xls">
    <button type="submit">Import</button>
</form>

@endsection